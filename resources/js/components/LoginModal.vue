<template>
    <div>
        <!-- مودال لاگین -->
        <v-dialog v-model="showModal" persistent max-width="400" overlay-click-close app style="border-radius: 30px" @close="closeModal">
            <v-card class="rounded-card">
                <!-- نمایش لودینگ -->
                <div v-if="isLoading" class="loading-container">
                    <v-progress-circular indeterminate color="warning"></v-progress-circular>
                </div>

                <!-- محتوای اصلی -->
                <div v-else>
                    <v-app-bar
                        color="rgba(0, 0, 0, 0.5)"
                        dark
                        dense
                        fixed
                        class="login-modal-app-bar"
                    >
                        <v-spacer></v-spacer>
                        <v-btn icon @click="toggleLanguage" style="color: white;">
                            <v-icon>mdi-earth</v-icon>
                        </v-btn>
                        <v-btn icon @click="closeModal" style="color: white;">
                            <v-icon>mdi-close</v-icon>
                        </v-btn>
                    </v-app-bar>

                    <!-- اسلایدشو اول -->
                    <div class="primary-slideshow">
                        <div v-if="items.length > 0" class="slide-wrapper">
                            <v-sheet class="d-flex flex-column align-center justify-center" :class="themeClass">
                                <img :src="items[currentSlide1].image" alt="banner" class="banner-image" />
                                <div class="text-overlay">
                                    <h3 class="slide-text" style="color: black">{{ items[currentSlide1].text12 }}</h3>
                                </div>
                            </v-sheet>
                        </div>
                    </div>


                    <!-- لوگو -->
                    <div class="logo-container">
                        <img :src="logo" alt="Company Logo" class="logo" />
                    </div>

                    <!-- اسلایدشو دوم -->
                    <div class="secondary-slideshow">
                        <div v-if="items2.length > 0" class="slide-wrapper">
                            <v-sheet class="d-flex flex-column align-center justify-center" style="background-color: transparent">
                                <div class="text-overlay2">
                                    <h3 class="slide-text2" style="color: white">{{ items2[currentSlide2].text2 }}</h3>
                                </div>
                            </v-sheet>
                        </div>
                    </div>

                    <!-- دکمه‌ها -->
                    <v-card class="rounded-card">
                        <v-card-actions class="d-flex flex-column align-center">
                            <v-btn class="my-2 other-methods-btn" @click="openLogin2Modal">
                                {{ translations[language].home.login2 }}
                            </v-btn>

                            <v-btn class="my-3 register-btn" @click="openRegisterModal">
                                {{ translations[language].home.register2 }}
                            </v-btn>
                        </v-card-actions>
                    </v-card>

                </div>
            </v-card>
        </v-dialog>


        <!-- مودال ثبت‌نام -->
        <v-dialog v-model="showRegisterModal" persistent max-width="400" overlay-click-close app style="border-radius: 30px">
            <v-card class="rounded-card">
                <div v-if="isLoading" class="loading-container">
                    <v-progress-circular indeterminate color="warning"></v-progress-circular>
                </div>

                <!-- محتوای اصلی -->
                <div v-else>
                    <v-app-bar
                        color="rgba(0, 0, 0, 0.5)"
                        dark
                        dense
                        fixed
                        class="login-modal-app-bar"
                    >
                        <v-spacer></v-spacer>
                        <v-btn icon @click="toggleLanguage" style="color: white;">
                            <v-icon>mdi-earth</v-icon>
                        </v-btn>
                        <v-btn icon @click="closeRegisterModal" style="color: white;">
                            <v-icon>mdi-close</v-icon>
                        </v-btn>

                    </v-app-bar>


                    <!-- محتوای ثبت‌نام -->
                    <div class="register-content">
                        <h2 class="register-title">{{ translations[language].home.createAccount }}</h2>
                        <v-sheet class="register-box">
                            <h3 class="signin-text">{{ translations[language].home.signIn }}</h3>
                            <p class="signin-subtext">{{ translations[language].home.fillDetails }}</p>
                            <v-text-field v-model="name" class="signin-subtext2" :label="translations[language].home.name" prepend-icon="mdi-account"></v-text-field>
                            <v-text-field v-model="surname" class="signin-subtext2" :label="translations[language].home.surname" prepend-icon="mdi-account"></v-text-field>
                            <v-text-field v-model="email" class="signin-subtext2" :label="translations[language].home.email" prepend-icon="mdi-email"></v-text-field>
                            <v-text-field v-model="password" class="signin-subtext2" :label="translations[language].home.password" prepend-icon="mdi-lock" :append-icon="showPassword ? 'mdi-eye' : 'mdi-eye-off'" :type="showPassword ? 'text' : 'password'" @click:append="togglePasswordVisibility"></v-text-field>

                            <v-btn class="register-submit-btn" color="primary" @click="register">{{ translations[language].home.submit }}</v-btn>

                        </v-sheet>
                    </div>
                </div>
            </v-card>
        </v-dialog>


        <!-- مودال ورود به حساب -->
        <v-dialog v-model="showLoginModal" persistent max-width="400" overlay-click-close app style="border-radius: 30px">
            <v-card class="rounded-card" style="position: relative;">
                <!-- انیمیشن بارگذاری -->
                <div v-if="isLoading" class="loading-container">
                    <v-progress-circular indeterminate color="warning"></v-progress-circular>
                </div>

                <!-- محتوای اصلی -->
                <div v-else>
                    <!-- لوگو و عنوان -->
                    <v-app-bar
                        color="rgba(0, 0, 0, 0.5)"
                        dark
                        dense
                        fixed
                        class="login-modal-app-bar"
                    >
                        <v-spacer></v-spacer>
                        <v-btn icon @click="toggleLanguage" style="color: white;">
                            <v-icon>mdi-earth</v-icon>
                        </v-btn>
                        <v-btn icon @click="closeLogin2Modal" style="color: white;">
                            <v-icon>mdi-close</v-icon>
                        </v-btn>
                    </v-app-bar>

                    <div class="modal-content">
                        <!-- لوگو -->
                        <div class="logo-container">
                            <img :src="logo" alt="Company Logo" class="logo" />
                        </div>
                        <h2 class="modal-title" >{{ translations[language].home.title }}</h2>

                        <!-- فرم ورود -->
                        <v-sheet class="form-container">
                            <h2 class="form-title">{{ translations[language].home.welcome }}</h2>
                            <p class="form-subtitle">{{ translations[language].home.signIn2 }}</p>
                            <form @submit.prevent="login">
                                <v-text-field
                                    ref="loginEmail"
                                    class="form-input"
                                    :label="translations[language].home.email"
                                    prepend-icon="mdi-email"
                                    autocomplete="email"
                                ></v-text-field>

                                <v-text-field
                                    ref="loginPassword"
                                    class="form-input"
                                    :label="translations[language].home.password"
                                    prepend-icon="mdi-lock"
                                    :append-icon="showPassword ? 'mdi-eye' : 'mdi-eye-off'"
                                    :type="showPassword ? 'text' : 'password'"
                                    @click:append="togglePasswordVisibility"
                                    autocomplete="current-password"
                                ></v-text-field>

                                <v-checkbox
                                    class="form-checkbox"
                                    :label="translations[language].home.rememberPassword"
                                ></v-checkbox>

                                <v-btn
                                    class="form-submit-btn"
                                    color="primary"
                                    @click="login"
                                >{{ translations[language].home.submit2 }}</v-btn>
                            </form>


                            <p class="forgot-password">
                                <!-- لینک برای باز کردن مودال بازیابی رمز عبور -->
                                <a href="#" @click.prevent="openForgotPasswordModal">{{ translations[language].home.forgotPassword }}</a>
                            </p>

                        </v-sheet>
                    </div>
                </div>
            </v-card>
        </v-dialog>

        <!-- مودال بازیابی رمز عبور -->
        <v-dialog v-model="showForgotPasswordModal" persistent max-width="400" height="500" overlay-click-close app style="border-radius: 30px">
            <v-card class="rounded-card" style="position: relative;">
                <!-- انیمیشن بارگذاری -->
                <div v-if="isLoading" class="loading-container">
                    <v-progress-circular indeterminate color="warning"></v-progress-circular>
                </div>

                <!-- محتوای اصلی -->
                <div v-else>
                    <!-- اپ بار بازیابی رمز عبور -->
                    <v-app-bar
                        class="reset-password-app-bar"
                        color="rgba(0, 0, 0, 0.5)"
                        dark
                        dense
                        fixed
                    >
                        <v-spacer></v-spacer>
                        <v-btn icon @click="toggleLanguage" style="color: white;">
                            <v-icon>mdi-earth</v-icon>
                        </v-btn>
                        <v-btn icon @click="closeForgotPasswordModal" style="color: white;">
                            <v-icon>mdi-close</v-icon>
                        </v-btn>
                    </v-app-bar>

                    <div class="modal-content">
                        <!-- لوگو -->
                        <div class="logo-container">
                            <img :src="logo" alt="Company Logo" class="logo" />
                        </div>
                        <h3 class="modal-title">{{ translations[language].home.title }}</h3>

                        <!-- فرم بازیابی رمز عبور -->
                        <v-sheet class="form-container">
                            <h2 class="form-title">{{ translations[language].home.rememberPassword }}</h2>
                            <p class="form-subtitle">{{ translations[language].home.instruction }}</p>

                            <v-text-field v-model="email" class="form-input" :label="translations[language].home.email" prepend-icon="mdi-email"></v-text-field>
                            <v-btn class="form-submit-btn" color="primary" @click="sendResetLink">{{ translations[language].home.submit3 }}</v-btn>

                            <p class="back-to-login">
                                <a @click="openLogin2Modal">{{ translations[language].home.backToLogin }}</a>
                            </p>
                        </v-sheet>
                    </div>
                </div>
            </v-card>
        </v-dialog>

    </div>
</template>

<script>
import faTranslations from "../locales/fa.json";
import enTranslations from "../locales/en.json";
import faSlides from "../locales/fa.json";
import enSlides from "../locales/en.json";
import { ElNotification } from 'element-plus'; // اضافه کردن ElNotification
import axios from 'axios';
import Dashboard from '../components/Dashboard.vue';

export default {
    components: {
        Dashboard,
    },
    name: "Login",
    data() {
        return {
            showForgotPasswordModal: false,
            name: '',
            surname: '',
            email: '',
            password: '',
            showLoginModal: false,
            isLoading: true,
            language: "fa",
            translations: {
                fa: faTranslations,
                en: enTranslations
            },
            items: faSlides.home.slides, // استفاده از آرایه اسلایدها برای نمایش
            logo: "/images/logo.png",
            items2: faSlides.home.slides2, // استفاده از آرایه اسلایدها برای نمایش
            currentSlide1: 0, // متغیر برای کنترل اسلاید جاری اول
            currentSlide2: 0, // متغیر برای کنترل اسلاید جاری دوم
            showModal: true,
            showRegisterModal: false,
            showPassword: false,
            token: null, // ذخیره توکن

        };
    },
    mounted() {
        const savedLanguage = localStorage.getItem('language');
        if (savedLanguage) {
            this.language = savedLanguage; // بازیابی زبان ذخیره شده
        }
        this.loadSlides(this.language);
        this.loadSlides2(this.language);

        setTimeout(() => {
            this.isLoading = false;
        }, 1000); // تاخیر 1 ثانیه برای نمایش لودینگ

        this.startSlideShow1();
        this.startSlideShow2();

    },
    methods: {
        startSlideShow1() {
            setInterval(() => {
                this.currentSlide1 = (this.currentSlide1 + 1) % this.items.length;
            }, 3000); // تغییر اسلاید اول هر ۳ ثانیه
        },
        startSlideShow2() {
            setInterval(() => {
                this.currentSlide2 = (this.currentSlide2 + 1) % this.items2.length;
            }, 3000); // تغییر اسلاید دوم هر ۳ ثانیه
        },

        loginWithGoogle() {
            // عملکرد ورود با حساب گوگل
        },
        showOtherMethodsModal() {
            // نمایش مودال روش‌های دیگر
        },
        toggleLanguage() {
            this.language = this.language === 'fa' ? 'en' : 'fa';
            localStorage.setItem('language', this.language); // ذخیره زبان در LocalStorage
            this.loadSlides(this.language); // بارگذاری اسلایدها با زبان جدید
            this.loadSlides2(this.language);
        },
        loadSlides(language) {
            if (language === "fa") {
                this.items = faSlides.home.slides; // بارگذاری اسلایدهای فارسی
            } else if (language === "en") {
                this.items = enSlides.home.slides; // بارگذاری اسلایدهای انگلیسی
            }
        },
        loadSlides2(language) {
            if (language === "fa") {
                this.items2 = faSlides.home.slides2; // بارگذاری اسلایدهای فارسی
            } else if (language === "en") {
                this.items2 = enSlides.home.slides2; // بارگذاری اسلایدهای انگلیسی
            }
        },
        openRegisterModal() {
            this.showModal = false;
            this.showRegisterModal = true;
            this.showloginModal = false; // اطمینان از بستن مودال لاگین 2
        },
        closeRegisterModal() {
            this.showRegisterModal = false;
            this.showModal = true; // باز کردن مودال لاگین اصلی
        },
        openLogin2Modal() {
            this.showModal = false;
            this.showRegisterModal = false;
            this.showLoginModal = true; // اطمینان از نام صحیح متغیر
            this.closeForgotPasswordModal(); // بستن مودال فراموشی رمز عبور
        },
        closeLogin2Modal() {
            this.showLoginModal = false; // اطمینان از نام صحیح متغیر
            this.showModal = true; // باز کردن مودال لاگین اصلی
        },
        closeModal() {
            this.showModal = false;
            this.showRegisterModal = false;
            this.showloginModal = false; // بستن همه مودال‌ها
        },

        togglePasswordVisibility() {
            this.showPassword = !this.showPassword;
        },
        showRegisterModal() {
            // Logic for showing register modal
        },
        showloginModal() {
            this.closeRegisterModal(); // بستن مودال ثبت‌نام
            this.closeModal();
            this.showloginModal = true; // باز کردن مودال لاگین 2
        },

        // باز کردن مودال فراموشی رمز عبور
        openForgotPasswordModal() {
            this.showForgotPasswordModal = true;
        },
        // بستن مودال فراموشی رمز عبور
        closeForgotPasswordModal() {
            this.showForgotPasswordModal = false;
        },
        // ارسال لینک بازیابی
        sendResetLink() {
            if (this.email) {
                this.isLoading = true;
                // ارسال درخواست به سرور برای بازیابی رمز عبور
                // فرض کنید از axios استفاده می‌کنید
                this.$axios.post('/api/reset-password', { email: this.email })
                    .then(response => {
                        // موفقیت‌آمیز
                        this.$notify.success('لینک بازیابی به ایمیل شما ارسال شد.');
                        this.email = ''; // پاک کردن ایمیل وارد شده
                        this.closeForgotPasswordModal(); // بستن مودال
                    })
                    .catch(error => {
                        // خطا
                        this.$notify.error('مشکلی پیش آمده است. لطفاً دوباره امتحان کنید.');
                    })
                    .finally(() => {
                        this.isLoading = false;
                    });
            } else {
                this.$notify.warning('لطفاً ایمیل خود را وارد کنید.');
            }
        },

        async register() {
            try {
                console.log('Registering with:', this.name, this.surname, this.email, this.password);
                const response = await this.$axios.post('/api/register', {
                    name: this.name,
                    surname: this.surname,
                    email: this.email,
                    password: this.password,
                    password_confirmation: this.password_confirmation  // افزودن فیلد password_confirmation
                });

                console.log('Registration successful:', response);

                // نمایش اعلان موفقیت‌آمیز
                ElNotification({
                    title: 'Success',
                    message: 'Registration successful!',
                    type: 'success'
                });

                // باز کردن مودال لاگین
                this.showLoginModal = true;

            } catch (error) {
                console.error('Error during registration:', error.response ? error.response.data : error.message);

                // نمایش اعلان خطا
                ElNotification({
                    title: 'Error',
                    message: 'An error occurred during registration.',
                    type: 'error'
                });
            }
        },
        async login() {
            try {
                const data = {
                    email: this.email,
                    password: this.password
                };
                console.log('Sending data:', data); // نمایش داده‌های ارسال‌شده

                const response = await axios.post('/api/login', data);
                if (response.data.success) {
                    this.$router.push('/dashboard');
                } else {
                    alert('Login failed: ' + response.data.message);
                }
            } catch (error) {
                if (error.response) {
                    console.log('Error response:', error.response.data); // نمایش پیام خطا
                } else {
                    console.log('Error:', error.message);
                }
            }
        }

    }
};
</script>

<style scoped>

.loading-container {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 200px; /* ارتفاع مورد نظر برای لودینگ */
}

.rounded-card {
    border-radius: 45px;
    padding-top: 0; /* اضافه کردن این مقدار برای ایجاد فضای کافی برای اپ بار */
}

.main-background {
    background-color: #000; /* پس‌زمینه مشکی */
    color: white; /* متن سفید */
    min-height: 100vh; /* حداقل ارتفاع صفحه */
}
.v-application .v-app-bar {
    top: 0 !important; /* مطمئن شوید که اپ بار همیشه بالا قرار می‌گیرد */
    left: 0;
    right: 0;
    position: absolute;
    z-index: 10; /* عددی بالا برای اطمینان از اینکه اپ بار بالاتر قرار می‌گیرد */

}

/* کلاس مربوط به افکت شیشه‌ای */
.blur-background {
    backdrop-filter: blur(8px); /* تنظیم محو شدن بیشتر */
    transition: backdrop-filter 0.6s ease;
}

.text-overlay {
    position: absolute;
    bottom: -20px;
    left: 0;
    right: 0;
    background-color: transparent;
    backdrop-filter: blur(5px);
    color: white; /* رنگ متن */
    padding: 20px; /* افزایش فاصله داخل */
    text-align: center; /* تراز مرکز */
    margin-bottom: 20px;
}


.slide-text {
    font-size: 18px;
    margin: 0;
    background-color: transparent;
    backdrop-filter: blur(5px);

}
.slide-text2 {
    font-size: 13px;
    margin: 0;
}

.rounded-card {
    border-radius: 30px; /* افزایش گردی گوشه‌ها */
    background-color: black;
    overflow: hidden; /* برای جلوگیری از بیرون زدگی محتوای گرد گوشه‌ها */
}

.banner-image {
    width: 100%;
    height: auto;
    display: block;
}

.modal-close-btn {
    position: absolute;
    top: 10px;
    left: 10px;
    z-index: 10;
}

.modal-close-btn v-icon {
    font-size: 18px; /* تنظیم اندازه آیکون */
}

.overlay {
    background: linear-gradient(to top, rgba(0, 0, 0, 0.7), transparent);
}

.company-logo {
    max-width: 150px;
    margin: auto;
}

.google-btn {
    background-color: #db4437;
    color: white;
}

.other-methods-btn {
    background-color: #00796b;
    color: white;
}

.register-btn {
    background-color: #1976d2;
    color: white;
}
@media (max-width: 1180px) {
    .login-modal .rounded-card .v-application{
        margin-top: -40px;
        position: relative;
    }
    .login-modal-app-bar {
        margin-top: -75px;

    }
    .reset-password-app-bar{
        margin-top: -95px;

    }
    .v-icon {
        color: white !important; /* تنظیم رنگ آیکون‌ها به مشکی */
    }

    .logo-container {
        margin-top: 30px; /* مقدار جدید برای لوگو در موبایل */
    }
    .primary-slideshow{
        margin-top: -50px;

    }
    .text-overlay {
        position: relative;
        margin-top: -90px;
    }

    .text-overlay2 {
        position: relative;
        margin-top: 10px;


    }
}

.v-navigation-drawer {
    z-index: 1000; /* مقدار کمتر از اپ بار مودال */
}
.login-modal-app-bar {
    position: fixed; /* یا absolute بسته به نیاز */
    top: 0;
    left: 0;
    right: 0;
    z-index: 1100; /* مقدار بیشتر از z-index منو همبرگری */

}
.logo-container {

    position: fixed;
    margin-top: 330px;
    align-content: center;
    align-items: center;
    padding-left:100px;
    z-index: 10; /* اضافه کردن z-index برای اطمینان از قرارگیری در لایه صحیح */

}

.logo {
    max-height: 60px; /* ارتفاع لوگو */
    max-width: 100%; /* عرض لوگو */
}



.secondary-slideshow {
    margin-top: 15px; /* ایجاد فاصله بین لوگو و اسلایدشو دوم */
    text-align: center;
}

.v-carousel .v-carousel__prev,
.v-carousel .v-carousel__next {
    display: none !important; /* مخفی کردن دکمه‌های ناوبری */
}

.primary-slideshow, .secondary-slideshow {
    margin-top: 50px;
    position: relative;
    width: 100%;
    text-align: center;
    margin-bottom: 20px;
}

.slide-wrapper {
    transition: opacity 1s ease-in-out;
    opacity: 1;
}

.text-overlay {
    text-align: center;
    color: black;

}


.text-overlay2 {
    color: white !important;
    text-align: center;
    size: 24px;
}

.my-2 {
    display: block; /*  قرارگیری زیر هم */
    justify-content: center;
    align-items: center;
    width: 80%; /* تنظیم عرض یکسان برای دکمه‌ها */
    max-width: 250px; /* حداکثر عرض برای دکمه‌ها */
    background: linear-gradient(135deg, #211C6A, #3795BD); /* رنگ گرادیان */
    color: white; /* رنگ متن */
    font-size: 16px; /* اندازه فونت */
    font-weight: bold; /* ضخامت فونت */
    border: none; /* حذف حاشیه */
    border-radius: 25px; /* گردی گوشه‌ها */
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2); /* سایه دکمه */
    cursor: pointer; /* تغییر شکل موس به نشانه‌ی دست */
    transition: all 0.3s ease; /* انتقال برای افکت‌ها */
    text-transform: uppercase; /* تبدیل متن به حروف بزرگ */
    text-align: center; /* تراز وسط برای متن */
}
.my-3{
    display: block; /* تغییر از inline-flex به block برای اطمینان از قرارگیری صحیح زیر هم */
    justify-content: center;
    align-items: center;
    width: 80%; /* تنظیم عرض یکسان برای دکمه‌ها */
    max-width: 250px; /* حداکثر عرض برای دکمه‌ها */
    background: linear-gradient(135deg, #365E32, #114232); /* رنگ گرادیان */
    color: white; /* رنگ متن */
    font-size: 16px; /* اندازه فونت */
    font-weight: bold; /* ضخامت فونت */
    border: none; /* حذف حاشیه */
    border-radius: 25px; /* گردی گوشه‌ها */
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2); /* سایه دکمه */
    cursor: pointer; /* تغییر شکل موس به نشانه‌ی دست */
    transition: all 0.3s ease; /* انتقال برای افکت‌ها */
    text-transform: uppercase; /* تبدیل متن به حروف بزرگ */
    text-align: center; /* تراز وسط برای متن */
}
.my-2:hover .my-3:hover {
    background: linear-gradient(135deg, #CDF5FD, #387F39); /* تغییر گرادیان در حالت هاور */
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3); /* افزایش سایه در حالت هاور */
    transform: translateY(-2px); /* تغییر مکان برای افکت برجسته‌سازی */
}

.my-2:active .my-3:active {
    transform: translateY(1px); /* تغییر مکان در حالت کلیک شده */
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2); /* کاهش سایه در حالت کلیک شده */
}

.register-content {
    margin-top: 15px;
    padding: 20px;
    text-align: center;
    background-color: black ;
}

.register-title {
    margin-top: 20px;
    font-size: 20px;
    font-weight: bold;
    color: #E2E2B6;
}

.register-box {
    background-color: #E2F6CA;
    padding: 20px;
    border-radius: 25px 25px 0 0; /* گردی فقط گوشه‌های بالا */
    margin-top: 20px;
}

.signin-text {
    font-size: 15px;
    margin-bottom: 5px;
}

.signin-subtext {
    font-size: 12px;
    color: #666;
    margin-bottom: 5px;
}
.signin-subtext2 {
    font-size: 10px;
    color: #666;
}

.register-submit-btn {
    margin-top: 10px;
    width: 80%;
}

/* استایل‌های موبایل */
@media (max-width: 768px) {
    .rounded-card {
        transform: scale(0.9); /* کاهش اندازه مودال به 80% */
        transform-origin: center; /* تعیین مرکز مقیاس‌گذاری */
    }

    .register-title {
        font-size: 20px; /* اندازه فونت عنوان برای موبایل */
    }

    .register-box {
        padding: 16px; /* کاهش فاصله داخلی مستطیل */
    }

    .signin-text {
        font-size: 16px; /* اندازه فونت Sign in برای موبایل */
    }

    .signin-subtext {
        font-size: 12px; /* اندازه فونت Fill in your account details برای موبایل */
    }

    .register-submit-btn {
        font-size: 14px; /* اندازه فونت دکمه ثبت نام */
        padding: 12px 20px; /* فاصله داخلی دکمه */
    }
}
.modal-content {
    padding: 16px;
    text-align: center;
}

.logo-container {
    margin: 0 auto;
    width: 100px; /* تنظیم عرض لوگو */
    height: 100px; /* تنظیم ارتفاع لوگو */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    border-radius: 50%;
    overflow: hidden;
}

.logo {
    width: 100%;
    height: auto;
}

.modal-title {
    margin-top: 16px;
    margin-bottom: 24px;
    color: #b0bec5;
    font-size: 15px;
}

.form-container {
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    border-radius: 16px;
    padding: 24px;
    background-color: #fff;
}

.form-title {
    margin: 0;
    color: #333;
    font-size: 20px;
}

.form-subtitle {
    margin: 8px 0 16px;
    color: #777;
    font-size: 16px;
}

.form-input {
    margin-bottom: 16px;
}

.form-submit-btn {
    width: 100%;
}

.back-to-login {
    margin-top: 16px;
}

.back-to-login a {
    color: #007bff;
    text-decoration: none;
}

.back-to-login a:hover {
    text-decoration: underline;
}
.small-text {
    font-size: 14px; /* می‌توانید اندازه مورد نظر خود را تنظیم کنید */
}

.reset-password-app-bar {
    position: fixed; /* اطمینان از ثابت بودن موقعیت */
    left: 0;
    right: 0;
    z-index: 1100; /* اطمینان از نمایش بالای سایر عناصر */
}


</style>
