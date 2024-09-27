import { createVuetify } from 'vuetify';
import '@mdi/font/css/materialdesignicons.css'; // اضافه کردن آیکن‌های mdi

export default createVuetify({
    icons: {
        defaultSet: 'mdi', // استفاده از Material Design Icons
    },
});
