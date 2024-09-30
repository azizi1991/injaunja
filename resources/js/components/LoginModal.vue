<template>
    <div>
        <v-dialog v-model="showModal" persistent max-width="400" overlay-click-close app style="border-radius: 30px" @close="closeModal">
            <v-card class="rounded-card">
                <div v-if="isLoading" class="loading-container">
                    <v-progress-circular indeterminate color="warning"></v-progress-circular>
                </div>

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


                    <div class="logo-container">
                        <img :src="logo" alt="Company Logo" class="logo" />
                    </div>

                    <div class="secondary-slideshow">
                        <div v-if="items2.length > 0" class="slide-wrapper">
                            <v-sheet class="d-flex flex-column align-center justify-center" style="background-color: transparent">
                                <div class="text-overlay2">
                                    <h3 class="slide-text2" style="color: white">{{ items2[currentSlide2].text2 }}</h3>
                                </div>
                            </v-sheet>
                        </div>
                    </div>

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


        <v-dialog v-model="showRegisterModal" persistent max-width="400" overlay-click-close app style="border-radius: 30px">
            <v-card class="rounded-card">
                <div v-if="isLoading" class="loading-container">
                    <v-progress-circular indeterminate color="warning"></v-progress-circular>
                </div>

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


        <v-dialog v-model="showLoginModal" persistent max-width="400" overlay-click-close app style="border-radius: 30px">
            <v-card class="rounded-card" style="position: relative;">
                <div v-if="isLoading" class="loading-container">
                    <v-progress-circular indeterminate color="warning"></v-progress-circular>
                </div>
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
                        <v-btn icon @click="closeLogin2Modal" style="color: white;">
                            <v-icon>mdi-close</v-icon>
                        </v-btn>
                    </v-app-bar>

                    <div class="modal-content">
                        <div class="logo-container">
                            <img :src="logo" alt="Company Logo" class="logo" />
                        </div>
                        <h2 class="modal-title">{{ translations[language].home.title }}</h2>

                        <v-sheet class="form-container">
                            <h2 class="form-title">{{ translations[language].home.welcome }}</h2>
                            <p class="form-subtitle">{{ translations[language].home.signIn2 }}</p>
                            <form @submit.prevent="login">
                                <v-text-field
                                    ref="loginEmail"
                                    class="form-input"
                                    :label="translations[language].home.email"
                                    prepend-icon="mdi-email"
                                    v-model="email"
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
                                    v-model="password"
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
                                <a href="#" @click.prevent="openForgotPasswordModal">{{ translations[language].home.forgotPassword }}</a>
                            </p>
                        </v-sheet>
                    </div>
                </div>
            </v-card>
        </v-dialog>

        <v-dialog v-model="showForgotPasswordModal" persistent max-width="400" height="500" overlay-click-close app style="border-radius: 30px">
            <v-card class="rounded-card" style="position: relative;">
                <div v-if="isLoading" class="loading-container">
                    <v-progress-circular indeterminate color="warning"></v-progress-circular>
                </div>

                <div v-else>
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
                        <div class="logo-container">
                            <img :src="logo" alt="Company Logo" class="logo" />
                        </div>
                        <h3 class="modal-title">{{ translations[language].home.title }}</h3>

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
            items: faSlides.home.slides,
            logo: "/images/logo.png",
            items2: faSlides.home.slides2,
            currentSlide1: 0,
            currentSlide2: 0,
            showModal: true,
            showRegisterModal: false,
            showPassword: false,
            token: null,

        };
    },
    mounted() {
        const savedLanguage = localStorage.getItem('language');
        if (savedLanguage) {
            this.language = savedLanguage;
        }
        this.loadSlides(this.language);
        this.loadSlides2(this.language);

        setTimeout(() => {
            this.isLoading = false;
        }, 1000);

        this.startSlideShow1();
        this.startSlideShow2();

    },
    methods: {
        startSlideShow1() {
            setInterval(() => {
                this.currentSlide1 = (this.currentSlide1 + 1) % this.items.length;
            }, 3000);
        },
        startSlideShow2() {
            setInterval(() => {
                this.currentSlide2 = (this.currentSlide2 + 1) % this.items2.length;
            }, 3000);
        },

        loginWithGoogle() {
        },
        showOtherMethodsModal() {
        },
        toggleLanguage() {
            this.language = this.language === 'fa' ? 'en' : 'fa';
            localStorage.setItem('language', this.language);
            this.loadSlides(this.language);
            this.loadSlides2(this.language);
        },
        loadSlides(language) {
            if (language === "fa") {
                this.items = faSlides.home.slides;
            } else if (language === "en") {
                this.items = enSlides.home.slides;
            }
        },
        loadSlides2(language) {
            if (language === "fa") {
                this.items2 = faSlides.home.slides2;
            } else if (language === "en") {
                this.items2 = enSlides.home.slides2;
            }
        },
        openRegisterModal() {
            this.showModal = false;
            this.showRegisterModal = true;
            this.showloginModal = false;
        },
        closeRegisterModal() {
            this.showRegisterModal = false;
            this.showModal = true;
        },
        openLogin2Modal() {
            this.showModal = false;
            this.showRegisterModal = false;
            this.showLoginModal = true;
            this.closeForgotPasswordModal();
        },
        closeLogin2Modal() {
            this.showLoginModal = false;
            this.showModal = true;
        },
        closeModal() {
            this.showModal = false;
            this.showRegisterModal = false;
            this.showloginModal = false;
        },

        togglePasswordVisibility() {
            this.showPassword = !this.showPassword;
        },
        showRegisterModal() {
        },
        showloginModal() {
            this.closeRegisterModal();
            this.closeModal();
            this.showloginModal = true;
        },

        openForgotPasswordModal() {
            this.showForgotPasswordModal = true;
        },
        closeForgotPasswordModal() {
            this.showForgotPasswordModal = false;
        },
        sendResetLink() {
            if (this.email) {
                this.isLoading = true;
                this.$axios.post('/api/reset-password', { email: this.email })
                    .then(response => {
                        this.$notify.success('لینک بازیابی به ایمیل شما ارسال شد.');
                        this.email = '';
                        this.closeForgotPasswordModal();
                    })
                    .catch(error => {

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
                });

                console.log('Registration successful:', response);

                ElNotification({
                    title: 'Success',
                    message: 'Registration successful!',
                    type: 'success',
                    center: true
                });

                this.showLoginModal = true;

            } catch (error) {
                console.error('Error during registration:', error.response ? error.response.data : error.message);

                ElNotification({
                    title: 'Error',
                    message: 'An error occurred during registration.',
                    type: 'error',
                    center: true
                });
            }
        },
        async login() {
            try {
                const data = {
                    email: this.email,
                    password: this.password,
                };
                console.log('Sending data:', data);

                const response = await axios.post('/api/login', data);
                if (response.data.success) {
                    ElNotification({
                        title: 'Success',
                        message: 'Login successful!',
                        type: 'success',
                        center: true,
                    });

                    window.location.href = '/dashboard';
                } else {
                    ElNotification({
                        title: 'Error',
                        message: 'Login failed: ' + response.data.message,
                        type: 'error',
                        center: true,
                    });
                }
            } catch (error) {
                if (error.response) {
                    console.log('Error response:', error.response.data);
                    ElNotification({
                        title: 'Error',
                        message: 'An error occurred during login.',
                        type: 'error',
                        center: true,
                    });
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
    height: 200px;
}

.rounded-card {
    border-radius: 45px;
    padding-top: 0;
}

.main-background {
    background-color: #000;
    color: white;
    min-height: 100vh;
}
.v-application .v-app-bar {
    top: 0 !important;
    left: 0;
    right: 0;
    position: absolute;
    z-index: 10;

}

.blur-background {
    backdrop-filter: blur(8px);
    transition: backdrop-filter 0.6s ease;
}

.text-overlay {
    position: absolute;
    bottom: -20px;
    left: 0;
    right: 0;
    background-color: transparent;
    backdrop-filter: blur(5px);
    color: white;
    padding: 20px;
    text-align: center;
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
    border-radius: 30px;
    background-color: black;
    overflow: hidden;
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
    font-size: 18px;
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
        color: white !important;
    }

    .logo-container {
        margin-top: 30px;
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
    z-index: 1000;
}
.login-modal-app-bar {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    z-index: 1100;

}
.logo-container {

    position: fixed;
    margin-top: 330px;
    align-content: center;
    align-items: center;
    padding-left:100px;
    z-index: 10;

}

.logo {
    max-height: 60px;
    max-width: 100%;
}



.secondary-slideshow {
    margin-top: 15px;
    text-align: center;
}

.v-carousel .v-carousel__prev,
.v-carousel .v-carousel__next {
    display: none !important;
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
    display: block;
    justify-content: center;
    align-items: center;
    width: 80%;
    max-width: 250px;
    background: linear-gradient(135deg, #211C6A, #3795BD);
    color: white;
    font-size: 16px;
    font-weight: bold;
    border: none;
    border-radius: 25px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    cursor: pointer;
    transition: all 0.3s ease;
    text-transform: uppercase;
    text-align: center;
}
.my-3{
    display: block;
    justify-content: center;
    align-items: center;
    width: 80%;
    max-width: 250px;
    background: linear-gradient(135deg, #365E32, #114232);
    color: white;
    font-size: 16px;
    font-weight: bold;
    border: none;
    border-radius: 25px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    cursor: pointer;
    transition: all 0.3s ease;
    text-transform: uppercase;
    text-align: center;
}
.my-2:hover .my-3:hover {
    background: linear-gradient(135deg, #CDF5FD, #387F39);
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3);
    transform: translateY(-2px);
}

.my-2:active .my-3:active {
    transform: translateY(1px);
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
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
    border-radius: 25px 25px 0 0;
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


@media (max-width: 768px) {
    .rounded-card {
        transform: scale(0.9);
        transform-origin: center;
    }

    .register-title {
        font-size: 20px;
    }

    .register-box {
        padding: 16px;
    }

    .signin-text {
        font-size: 16px;
    }

    .signin-subtext {
        font-size: 12px;
    }

    .register-submit-btn {
        font-size: 14px;
        padding: 12px 20px;
    }
}
.modal-content {
    padding: 16px;
    text-align: center;
}

.logo-container {
    margin: 0 auto;
    width: 100px;
    height: 100px;
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
    font-size: 14px;
}

.reset-password-app-bar {
    position: fixed;
    left: 0;
    right: 0;
    z-index: 1100;
}


</style>
