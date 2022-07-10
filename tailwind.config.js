const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Nunito', ...defaultTheme.fontFamily.sans],
        },
        textColor: {
          'logout': '#001A66',
          'normal': '#333',
          'primary-button': '#F5F5F5',
          'secondary-button': '#8A121E',
          'validation-error': '#B94A48',
        },
        colors: {
          'top-bar': '#8A121E',
          'header': '#EBEBEB',
          'navbar-item': '#F5F5F5',
          'footer': '#61605C',
          'separator': '#DDDDDD',
          'primary-button': '#8A121E',
          'secondary-button': '#F5F5F5',
          'input-field': '#FFF7E8',
          'focused-input-field-outline': '#E3AA7F',
          'system-information': '#E3F0FF',
          'hoverd-login-button': '#C4878E',
          'base': '#EBEBEB', // 要素をこの要素に重ねるように配置する
          'comment': '#F9F9F9',
          'first-row': '#F0F0F0',
          'second-row': '#F9F9F9',
          // Faculty colors
          'business': '#E7290F',
          'business-sub': '#F55944',
          'ict': '#004098',
          'ict-sub': '#708BC7',
          'anime': '#DD0079',
          'anime-sub': '#E2A0C4',

          // Others Manu Button
          'others-menu-button': '#34008F',
          'others-menu-sub-button': '#3700B8',
          'others-name-bar': '#F0F0F0',
          'others-menu-items': '#E6CFD0',
        },
        fontSize: {
          'primary': '16px',
          'secondary': '15px',
          'tertiary': '13px',
          'normal': '15px',
        },
        // backgroundImage: {
        //   'bg-img-body': "url('./public/images/bg-image-top.png')",
        // },
      },      
    },

    variants: {
        extend: {
            opacity: ['disabled'],
        },
    },

    plugins: [require('@tailwindcss/forms')],
};
