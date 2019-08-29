<?php

namespace App\Http\Controllers;

use App\Http\Resources\AnnuityCollection;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class CalcController extends Controller
{
    /**
     * @param Request $request
     * @return AnnuityCollection|\Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function __invoke(Request $request)
    {
        $this->validateForm($request);

        $total = $request->amount;
        $rate = $request->rate / 100 / 12;
        if($request->period_type==='year') {
            $period = $request->period * 12;
        } else {
            $period = $request->period;
        }

        $annuity = $this->getAnnuity($total, $rate, $period);

        if ($request->input('detailed')) {
            $detailed = $this->getDetailedAnnuity($total, $rate, $period, $annuity);
            return (new AnnuityCollection($detailed))->additional(compact('annuity'));
        }

        return response()->json(compact('annuity'), 200);
    }

    /**
     * @param Request $request
     * @throws \Illuminate\Validation\ValidationException
     */
    private function validateForm(Request $request)
    {
        $rules = [
            'amount' => ['required', 'integer', 'between:500000,1000000'],
            'rate' => ['required', 'integer', 'between:1,100'],
            'period' => ['required', 'integer', 'between:10,50'],
            'detailed' => ['boolean']
        ];
        if ($request->get('period_type') == 'month') {
            $rules['period'] = ['required', 'integer', 'between:120,600'];
        }

        $this->validate($request,
            $rules,
            [
                'between' => [
                    'numeric' => 'Поле :attribute должно быть между :min и :max.',
                    'file' => 'Размер файла в поле :attribute должен быть между :min и :max Килобайт(а).',
                    'string' => 'Количество символов в поле :attribute должно быть между :min и :max.',
                    'array' => 'Количество элементов в поле :attribute должно быть между :min и :max.',
                ],
                'integer' => 'Поле :attribute должно быть целым числом.',
                'required' => 'Поле :attribute обязательно для заполнения.',

            ],
            [
                'amount' => 'Сумма кредита',
                'rate' => 'Годовая процентная ставка',
                'period' => 'Срок кредита',
            ]
        );
    }

    /**
     * @param $total
     * @param $rate
     * @param $period
     * @return float
     */
    private function getAnnuity($total, $rate, $period)
    {
        return $total * $rate * (1 + 1 / (pow(1 + $rate, $period) - 1));
    }

    /**
     * @param $total
     * @param $rate
     * @param $period
     * @param $annuity
     * @return Collection
     */
    private function getDetailedAnnuity($total, $rate, $period, $annuity)
    {
        $annuityTable = new Collection();

        for ($num = 1; $num <= $period; $num++) {
            $interest = $total * $rate;
            $repayment = $annuity - $interest;
            $debt = round($total - $repayment, 2);
            $annuityTable->push(compact('num', 'interest', 'repayment', 'debt'));
            $total -= $repayment;
        }
        return $annuityTable;
    }
}
