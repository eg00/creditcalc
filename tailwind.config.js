module.exports = {
    theme: {
        fontFamily: {
            body: ['Open Sans', 'sans-serif'],
            heading: ['Montserrat', 'sans-serif'],
        },
        customForms: theme => ({
            default: {
                input: {
                    borderRadius: theme('borderRadius.default'),
                    borderColor: theme('colors.gray.100'),
                    borderWidth: theme('borderWidth.2'),
                    backgroundColor: theme('colors.gray.100'),
                    '&:focus': {
                        backgroundColor: theme('colors.white'),
                        borderColor: theme('colors.blue.500'),
                        boxShadow: 'none'
                    }
                },
                select: {
                    borderRadius: theme('borderRadius.default'),
                    borderColor: theme('colors.gray.100'),
                    borderWidth: theme('borderWidth.2'),
                    backgroundColor: theme('colors.gray.100'),
                    boxShadow: 'none',
                    '&:focus': {
                        backgroundColor: theme('colors.white'),
                        borderColor: theme('colors.blue.500'),
                        boxShadow: 'none'
                    }
                },
                checkbox: {
                    width: theme('spacing.6'),
                    height: theme('spacing.6'),
                    backgroundColor: theme('colors.gray.100'),
                    borderColor: theme('colors.gray.400'),
                    '&:focus': {
                        boxShadow: 'none'
                    }
                },
            },
        }),
        extend: {
            minHeight: {
                '1/2': '50%',
            },
            minWidth: {
                '1/2': '50%',
            },
        }
    },
    variants: {},
    plugins: [
        require('@tailwindcss/custom-forms'),
    ]
};
