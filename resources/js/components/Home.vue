
<template >
    <v-app :class="themeClass" class="app-background">
        <div >
            <!-- نمایش لودینگ -->
            <div v-if="isLoading" class="loading-container">
                <v-progress-circular indeterminate color="warning"></v-progress-circular>
            </div>

            <!-- محتوای اصلی -->
            <div v-else>
                <div class="main-container" style="margin-bottom: 100px" >
                    <div class="logo-container">
                        <img :src="logo" alt="Company Logo" class="logo" />
                    </div>

                    <!-- بخش آیکون‌ها و ایمیل شرکت -->
                    <div class="contact-info">
                        <div class="email">
                            <p>Email: contact@company.com</p>
                        </div>


                        <div class="social-icons">
                            <a href="https://instagram.com/yourprofile" target="_blank">
                                <v-icon class="social-icon">mdi-instagram</v-icon>
                            </a>
                            <a href="mailto:youremail@example.com" target="_blank">
                                <v-icon class="social-icon">mdi-email</v-icon>
                            </a>
                            <a href="https://linkedin.com/in/yourprofile" target="_blank">
                                <v-icon class="social-icon">mdi-linkedin</v-icon>
                            </a>
                            <a href="https://facebook.com/yourprofile" target="_blank">
                                <v-icon class="social-icon">mdi-facebook</v-icon>
                            </a>
                            <a href="https://wa.me/989123456789" target="_blank">
                                <v-icon class="social-icon">mdi-whatsapp</v-icon>
                            </a>
                        </div>
                    </div>



                    <v-container fluid class="banner-slideshow" style="background-color: transparent">
                        <Swiper
                            cycle
                            :slides-per-view="1"
                            pagination
                            autoplay="{ delay: 3000, disableOnInteraction: false }"
                            loop
                            effect="fade"
                        >
                            <SwiperSlide v-for="(banner, index) in banners" :key="index">
                                <v-sheet class="d-flex flex-column align-center justify-center" :class="themeClass" style="background-color: transparent">
                                    <img :src="banner.image" alt="banner" class="banner-image" />
                                    <v-btn color="#8EACCD" :style="{ borderRadius: '15px', fontSize: buttonFontSize, width: 'auto', color: 'black' }" @click="viewMore(banner)">
                                        {{ t('home.viewmore') }}
                                    </v-btn>
                                </v-sheet>
                            </SwiperSlide>
                        </Swiper>
                    </v-container>


                    <div  class="main2-container">
                        <!-- App Bar -->
                        <v-app-bar
                            app
                            flat
                            color="transparent"
                            class="hamburger-menu login-modal"
                            v-if="isMobile"
                            style="justify-content: flex-end;"
                        >
                            <v-app-bar-nav-icon
                                @click="drawer = !drawer"
                                style="color: white"
                            ></v-app-bar-nav-icon>
                            <v-btn icon @click="toggleLanguage" style="color: white;">
                                <v-icon>mdi-earth</v-icon>
                            </v-btn>
                            <v-tooltip bottom>
                                <template v-slot:activator="{ on, attrs }">
                                    <v-btn icon v-bind="attrs" v-on="on" @click="openSearchDialog">
                                        <v-icon style="color: white"> mdi-magnify</v-icon>
                                    </v-btn>
                                </template>
                                <span>{{ t('home.search') }}</span>
                            </v-tooltip>
                        </v-app-bar>


                        <!-- Navigation Drawer -->
                        <v-navigation-drawer
                            v-model="drawer"
                            app
                            temporary
                            right
                            class="hamburger-drawer"
                            v-if="isMobile"

                        >

                            <div class="buttons2-container">
                                <v-btn class="equal-btn"  style="border-color: saddlebrown; justify-content: center;" @click="showModal = true">{{ t('home.Login') }}</v-btn>
                                <login-modal v-if="showModal" :key="modalKey" @close="closeModal"></login-modal>

                                <v-btn @click="scrollToCantactUs" class="equal-btn">{{ t('home.Contactus') }}</v-btn>
                                <v-btn class="equal-btn">{{ t('home.Ourservices') }}</v-btn>
                                <v-btn @click="scrollToAboutUs" class="equal-btn">{{ t('home.Aboutus') }}</v-btn> <!-- اینجا دکمه قرار دارد -->
                            </div>
                        </v-navigation-drawer>
                        <!-- Top Buttons for Desktop -->
                        <div v-if="!isMobile" class="buttons2-container" style="justify-content: flex-end;">
                            <v-btn @click="scrollToCantactUs" class="equal-btn">{{ t('home.Contactus') }}</v-btn>
                            <v-btn class="equal-btn">{{ t('home.Ourservices') }}</v-btn>
                            <v-btn @click="scrollToAboutUs" class="equal-btn">{{ t('home.Aboutus') }}</v-btn> <!-- اینجا دکمه قرار دارد -->
                        </div>

                        <div v-if="!isMobile" class="button1-container" style="justify-content: flex-end;">
                            <v-btn icon @click="toggleLanguage" style="color: black">
                                <v-icon>mdi-earth</v-icon>
                            </v-btn>
                            <v-tooltip bottom>
                                <template v-slot:activator="{ on, attrs }">
                                    <v-btn icon v-bind="attrs" v-on="on" @click="openSearchDialog" style="color: black">
                                        <v-icon>mdi-magnify</v-icon>
                                    </v-btn>
                                </template>
                                <span>{{ t('home.search') }}</span>
                            </v-tooltip>
                            <v-btn class="equal-btn" style="border-color: saddlebrown; justify-content: center;" @click="openModal">{{ t('home.Login') }}</v-btn>
                            <login-modal v-if="showModal" :key="modalKey" @close="closeModal"></login-modal>

                        </div>

                        <!-- Semi-transparent search bar -->
                        <v-dialog v-model="searchDialog" max-width="800px" class="search-dialog">
                            <v-card>
                                <v-card-title>
                                    <span>{{ t('home.search') }}</span>
                                    <v-spacer></v-spacer>
                                    <v-btn icon @click="closeSearchDialog">
                                        <v-icon>mdi-close</v-icon>
                                    </v-btn>
                                </v-card-title>
                                <v-card-text>
                                    <v-container fluid class="search-container">
                                        <v-row align="center" justify="center">
                                            <v-col class="text-center" cols="12" md="8">
                                                <v-row class="mt-5" no-gutters>
                                                    <v-col cols="6">
                                                        <v-text-field
                                                            prepend-inner-icon="mdi-map-marker"
                                                            :label="translations[language].location"
                                                            single-line
                                                            hide-details
                                                            filled
                                                            @click="showMap = true"
                                                        ></v-text-field>
                                                    </v-col>
                                                    <v-col cols="6">
                                                        <v-text-field
                                                            prepend-inner-icon="mdi-magnify"
                                                            :label="translations[language].search2"
                                                            single-line
                                                            hide-details
                                                            filled
                                                        ></v-text-field>
                                                    </v-col>
                                                </v-row>
                                            </v-col>
                                        </v-row>
                                    </v-container>
                                </v-card-text>
                            </v-card>
                        </v-dialog>
                        <v-dialog v-model="showMap" width="600">
                            <v-card>
                                <v-card-title>
                                    <span>{{ t('home.yourLocation') }}</span>
                                    <v-spacer></v-spacer>
                                    <v-btn icon @click="closeSearchDialog">
                                        <v-icon>mdi-close</v-icon>
                                    </v-btn>
                                </v-card-title>
                                <v-card-text>
                                    <div id="map"></div>
                                </v-card-text>
                            </v-card>
                        </v-dialog>


                        <!-- Categories Slider -->
                        <v-container fluid class="categories-slider" style="margin-top: 0">
                            <v-row class="d-flex justify-center ">
                                <v-col cols="4" md="2" class="text-center category-col">
                                    <v-img src="/images/image1.png" class="category-image"></v-img>
                                    <v-btn :class="{'category-btn-english': isEnglish(t('home.Fellowtraveler')), 'category-btn': true}" block @click="selectCategory('Fellowtraveler', $event)">
                                        <div>{{ t('home.Fellowtraveler') }}</div>
                                    </v-btn>

                                </v-col>
                                <v-col cols="4" md="2" class="text-center category-col">
                                    <v-img src="/images/image2.png" class="category-image"></v-img>
                                    <v-btn class="category-btn" block @click="selectCategory('Vehicle', $event)">
                                        <div>{{ t('home.FindCarRental') }}</div>
                                    </v-btn>
                                </v-col>
                                <v-col cols="4" md="2" class="text-center category-col">
                                    <v-img src="/images/image3.png" class="category-image"></v-img>
                                    <v-btn class="category-btn" block @click="selectCategory('Home', $event)">
                                        <div>{{ t('home.FindRenthome') }}</div>
                                    </v-btn>
                                </v-col>
                            </v-row>
                        </v-container>

                        <v-container fluid class="categories-slider" style="margin-top: 5px">
                            <v-row class="d-flex justify-center ">
                                <v-col cols="4" md="2" class="text-center category-col">

                                </v-col>
                                <v-col cols="4" md="2" class="text-center category-col">

                                </v-col>
                                <v-col cols="4" md="2" class="text-center category-col">

                                </v-col>
                            </v-row>
                        </v-container>
                        <v-container fluid class="categories-slider" style="margin-top: 5px">
                            <v-row class="d-flex justify-center ">
                                <v-col cols="4" md="2" class="text-center category-col">

                                </v-col>
                                <v-col cols="4" md="2" class="text-center category-col">

                                </v-col>
                                <v-col cols="4" md="2" class="text-center category-col">

                                </v-col>
                            </v-row>
                        </v-container>
                        <v-container fluid class="categories-slider" style="margin-top: 5px">
                            <v-row class="d-flex justify-center ">
                                <v-col cols="4" md="2" class="text-center category-col">

                                </v-col>
                                <v-col cols="4" md="2" class="text-center category-col">

                                </v-col>
                                <v-col cols="4" md="2" class="text-center category-col">

                                </v-col>
                            </v-row>
                        </v-container>


                        <!-- Buttons Container -->
                        <div class="container11">
                            <div class="button-container11">
                                <button class="square-button">{{ t('home.Whatsgoingoncity') }}</button>
                                <button class="square-button">{{ t('home.Goodfoodcoolplace') }}</button>
                                <button class="square-button">{{ t('home.Introducecity') }}</button>
                                <button class="square-button">{{ t('home.Popularcities') }}</button>
                                <button class="square-button">{{ t('home.Wherewegoincity') }}</button>
                            </div>
                        </div>



                    </div>
                    <div class="spacer"></div>


                </div>


                <!--    main3 -->
                <div  class="main3-container" style="padding-top: 50px; ">
                    <div class="spacer"></div>

                    <!-- اگهی های هاست -->
                    <v-container class="HostAd" fluid style="background-color: black">
                        <v-row>
                            <v-col cols="12" md="6" v-for="(place, index) in places" :key="index" class="mb-4"
                                   style="background-color:rgba(0, 0, 0, 0.9); "
                                   data-aos="fade-up"
                                   data-aos-duration="1000"
                                   data-aos-delay="200">

                                <v-hover v-slot:default="{ isHovering }">
                                    <v-card
                                        @click="navigateToPage(place.url)"
                                        elevation="3"
                                        class="rounded-lg d-flex flex-column align-center justify-center "
                                        style="overflow: hidden; border-radius: 20px; cursor: pointer; position: relative; height: 400px;"
                                    >
                                        <!-- اسلاید شو عکس‌ها -->
                                        <swiper style=" background-color:rgba(0, 0, 0, 0.5) "
                                                :slides-per-view="1"
                                                loop
                                                pagination
                                                effect="fade"
                                                class="featured-listing-swiper"
                                        >
                                            <swiper-slide v-for="(image, i) in place.images" :key="i">
                                                <v-img
                                                    :src="image"
                                                    class="image"
                                                    height="300px"
                                                    border-radius="20px"
                                                ></v-img>
                                            </swiper-slide>
                                        </swiper>

                                        <!-- اطلاعات میزبان و آیکون قلب -->
                                        <v-card-actions
                                            class="d-flex justify-space-between"
                                            style="position: absolute; bottom: 0; width: 100%; background-color: rgba(0, 0, 0, 0.5); color: black;"
                                        >
                                            <v-card-title class="hover-title2">
                                                {{ place.hostName }}
                                            </v-card-title>
                                            <v-btn
                                                icon
                                                @click.stop="toggleFavorite(place)"
                                                class="favorite-button"
                                            >
                                                <v-icon>{{ place.isFavorite ? 'mdi-heart' : 'mdi-heart-outline' }}</v-icon>
                                            </v-btn>
                                        </v-card-actions>
                                    </v-card>
                                </v-hover>
                            </v-col>
                        </v-row>
                    </v-container>
                </div>

                <div class="spacer"></div>
                <div class="spacer"></div>

                <!--  About us -->
                <div id="about-us" class="about-us-container" style="background-color: black;">
                    <v-container>
                        <!-- بخش اول: معرفی شرکت -->
                        <v-row class="my-12"
                               data-aos="flip-up"
                               data-aos-duration="1000"
                               data-aos-delay="200">
                            <v-col>
                                <h1 class="text-center">{{ t('home.whoweare') }}</h1>

                                <v-col cols="12">
                                    <v-img
                                        :src="logo" alt="Company Logo"
                                        height="150px"
                                        width="150px"
                                        class="logo-style"
                                        style="margin: 0 auto; display: block;"
                                        data-aos="zoom-in"
                                        data-aos-duration="1000"
                                        data-aos-delay="200"
                                    ></v-img>
                                </v-col>
                            </v-col>
                        </v-row>

                        <!-- بخش دوم: تاریخچه شرکت -->
                        <v-row
                            class="my-12"
                            style="background-color: black; color: white; text-align: center; padding: 20px;"
                            data-aos="flip-up"
                            data-aos-duration="1000"
                            data-aos-delay="200"
                        >
                            <!-- اضافه کردن ویژگی density برای تنظیم نمای موبایل -->
                            <v-timeline density="comfortable">
                                <v-timeline-item
                                    v-for="(event, index) in timelineEvents"
                                    :key="index"
                                    :color="event.color"
                                >
                                    <v-card
                                        style="background-color: transparent; color: white; text-align: center;"
                                        class="pa-4"
                                    >
                                        <v-card-title>{{ event.title }}</v-card-title>
                                        <v-card-text
                                            style="line-height: 1.6; color: white; text-align: center;"
                                            class="pa-2"
                                        >
                                            {{ event.text }}
                                        </v-card-text>
                                    </v-card>
                                </v-timeline-item>
                            </v-timeline>
                        </v-row>

                        <!-- بخش سوم: تیم ما -->
                        <v-row class="my-12">
                            <v-col v-for="(member, index) in teamMembers" :key="index" cols="12" sm="6" md="4"
                                   data-aos="zoom-in-up"
                                   data-aos-duration="1000"
                                   data-aos-delay="200">
                                <v-card style="background-color: black; color: white; text-align: center;">
                                    <v-img
                                        :src="member.image"
                                        height="200px"
                                        style="justify-items: center; object-fit: cover;"
                                    ></v-img>
                                    <v-card-title style="color: white;">{{ member.name }}</v-card-title>
                                    <v-card-subtitle style="color: #bbbbbb;">{{ member.role }}</v-card-subtitle>
                                </v-card>
                            </v-col>
                        </v-row>


                        <!-- بخش چهارم: ارزش‌ها و چشم‌انداز -->
                        <v-row class="my-12">
                            <v-col>
                                <h2 class="text-center">{{t('home.Ourvaluesandvision')}}</h2>
                                <v-row>
                                    <v-col
                                        v-for="(value, index) in values"
                                        :key="index"
                                        cols="12" sm="6" md="3"
                                    >
                                        <!-- استفاده از dotlottie-player برای هر آیتم ارزش -->
                                        <!--                                <dotlottie-player
                                                                            :src="value.lottieUrl"
                                                                            autoplay
                                                                            loop
                                                                            style="width: 100px; height: 100px;"
                                                                        ></dotlottie-player>-->
                                        <p class="text-center">{{ value.text }}</p>
                                    </v-col>
                                </v-row>
                            </v-col>
                        </v-row>


                    </v-container>




                </div>
                <div id="contact-us" class="contact-us-container" style="background-color: black;">
                    <v-container>
                        <!-- بخش پنجم: تماس با ما -->
                        <v-row class="my-12">
                            <v-col>

                                <h2 class="text-center">{{ t('home.contactus') }}</h2>
                                <v-form>
                                    <v-text-field :label="t('home.name')"></v-text-field>
                                    <v-text-field :label="t('home.email')"></v-text-field>
                                    <v-text-field :label="t('home.subject')"></v-text-field>
                                    <v-textarea :label="t('home.message')"></v-textarea>
                                    <v-btn color="primary">{{ t('home.send') }}</v-btn>
                                </v-form>

                            </v-col>
                        </v-row>


                        <!-- بخش آیکون‌ها و ایمیل شرکت -->
                        <div class="contact-info2">
                            <div class="email2">
                                <p>Email: contact@company.com</p>
                            </div>
                            <div class="social-icons2">
                                <a href="https://instagram.com/yourprofile" target="_blank">
                                    <v-icon class="social-icon2">mdi-instagram</v-icon>
                                </a>
                                <a href="mailto:youremail@example.com" target="_blank">
                                    <v-icon class="social-icon2">mdi-email</v-icon>
                                </a>
                                <a href="https://linkedin.com/in/yourprofile" target="_blank">
                                    <v-icon class="social-icon2">mdi-linkedin</v-icon>
                                </a>
                                <a href="https://facebook.com/yourprofile" target="_blank">
                                    <v-icon class="social-icon2">mdi-facebook</v-icon>
                                </a>
                                <a href="https://wa.me/989123456789" target="_blank">
                                    <v-icon class="social-icon2">mdi-whatsapp</v-icon>
                                </a>
                            </div>

                        </div>

                    </v-container>
                </div>
                <div class="whatsapp-float">
                    <a href="https://wa.me/989035044816" target="_blank" class="whatsapp-link">
                        <i class="fab fa-whatsapp whatsapp-icon"></i>
                    </a>
                </div>
            </div>
        </div>
    </v-app>
</template>



<script>
import L from 'leaflet';  // وارد کردن کتابخانه‌ی نقشه‌ی Leaflet
import faTranslations from '../locales/fa.json';
import enTranslations from '../locales/en.json';
import { Swiper, SwiperSlide } from 'swiper/vue';
import 'swiper/swiper-bundle.css';
import { VBtn, VCardTitle, VIcon } from 'vuetify/components';
import AOS from 'aos';
import 'aos/dist/aos.css';
import LoginModal from './LoginModal.vue';

AOS.init();

export default {

    name: "Home",
    components: {
        Swiper,
        SwiperSlide,
        VBtn,
        VCardTitle,
        VIcon,
        LoginModal,
    },
    data() {
        return {
            drawer: false,
            isMobile: false,
            isLoading: true,

            isLoggedIn: false,
            loginDialog: false,
            selectedRole: null,
            userRole: '',
            showMenu: false,
            showModal: false,
            modalKey: 0,
            showOtherMethods: false,
            showRegisterModal: false,
            locationQuery: '',
            search2Query: '',
            searchDialog: false,
            searchQuery: '',
            showMap: false,
            isDark: false,
            logo: "/images/logo.png",
            language: 'fa',

            translations: {
                fa: faTranslations,
                en: enTranslations
            },


            timelineEvents: [

                {
                    title: 'injaunja',
                    text: 'injaunja is a startup that provide platform for immigrants and travellers to\\nconnect with hosts from their homelandoffering culturally familiar\\naccommodations and vehicle rentals\\n and finding fellow travellers and tour\\n organizers. Our initial focus is on the\\n Iranian community abroad, leveragin\\n our familiarity with Iranian culture to\\n ensure comfort and trust',
                    color: 'primary'
                },
                {
                    title: 'Service Description',
                    text: 'injaunja connects immigrants and travellers with hosts from their homeland,\noffering culturally familiar short-term accommodations and vehicle rentals.\nUsers can also find travel partners to share their journeys and split expenses, making the experience more enjoyable and cost-effective. \nAdditionally, the app allows users to organize tourist tours.\nEach version of the app is available in the local language, ensuring ease of use.',

                    color: 'success'
                }
            ],
            teamMembers: [
                { name: 'Armin Shamseddini', role: 'Founder-C.E.O', image: '/images/profile (1).jpg' },
                { name: 'Javid Shams', role: 'Founder-C.T.O', image: '/images/profile (2).jpg' },
                { name: 'Zahra Azizi', role: 'Founder-C.O.O', image: '/images/profile (3).jpg' },

            ],
            values: [
                {

                },
                {

                },
                // سایر ارزش‌ها
            ],



            selectedCategory: null,
            showCategoryImages: true,
            categories: {
                travelingCompanion: {
                    title: "Find traveling Companion",
                    items: [
                        { title: "John Doe", description: "Looking for a travel companion to Paris.", image: "/images/traveler1.jpg", location: "Paris, France" },
                        { title: "Jane Smith", description: "Seeking a traveling Companion for a road trip across the USA.", image: "/images/traveler2.jpg", location: "New York, USA" },
                    ],
                },
                CarRental: {
                    title: "Find Car Rental",
                    items: [
                        { title: "Car Rental", description: "Affordable car rental in your city.", image: "/images/car_rental.jpg", location: "Tehran, Iran" },
                        { title: "Bike Rental", description: "Eco-friendly bike rentals available now.", image: "/images/bike_rental.jpg", location: "Isfahan, Iran" },
                    ],
                },
                Renthome: {
                    title: "Find Renthome",
                    items: [
                        { title: "Apartment in London", description: "A cozy 2-bedroom apartment in central London.", image: "/images/apartment1.jpg", location: "London, UK" },
                        { title: "Beach House", description: "Beautiful beach house with ocean views.", image: "/images/beach_house.jpg", location: "Malibu, USA" },
                    ],
                },
            },
            currentSlide: 0,

            banners: [
                {
                    image:  "/images/banner1.jpg",
                    title: 'Special Discount!',
                    description: 'Get 20% off on all services this month.',
                },
                {
                    image: "/images/banner2.jpg",
                    title: 'Company Info',
                    description: 'Learn more about our services.',
                },
                {
                    image: "/images/banner3.jpg",
                    title: 'Company Info',
                    description: 'Learn more about our services.',
                },

            ],
            themeClass: '',
            buttonFontSize: '',
            places: [
                {
                    url: "https://example.com/place1",
                    images: [
                        "/images/1_host (1).jpg",
                        "/images/1_host (2).jpg",
                        "/images/1_host (3).jpg",
                    ],
                    isFavorite: false,

                    hostName: "ali alavi"
                },
                {
                    url: "https://example.com/place2",
                    images: [
                        "/images/2_host (1).jpg",
                        "/images/2_host (2).jpg",
                        "/images/2_host (3).jpg",
                    ],
                    isFavorite: false,

                    hostName: "sara sami"
                },
                {
                    url: "https://example.com/place3",
                    images: [
                        "/images/3_host (1).jpg",
                        "/images/3_host (2).jpg",
                    ],
                    isFavorite: false,

                    hostName: "hami misaq"
                },
            ]
        };
    },
    computed: {

        currentPanel() {
          /*  switch (this.userRole) {
                case 'admin':
                    return 'AdminPanel';
                case 'host':
                    return 'HostPanel';
                case 'guest':
                    return 'GuestPanel';
                default:
                    return 'GuestPanel';
            }*/
        },


        selectedCategoryTitle() {
            return this.translations[this.language][this.selectedCategory];
        },
        selectedCategoryItems() {
            return this.selectedCategory && this.showCategoryImages ? this.categories[this.selectedCategory].items : [];
        },
        themeClass() {
            return this.isDark ? 'dark-theme' : 'light-theme';
        },
        buttonFontSize() {
            if (this.language === 'fa') {
                if (window.innerWidth > 960) {
                    return '15px';
                } else if (window.innerWidth > 600) {
                    return '13px';
                } else {
                    return '11px';
                }
            } else {
                if (window.innerWidth > 960) {
                    return '12px';
                } else if (window.innerWidth > 600) {
                    return '10px';
                } else {
                    return '8px';
                }
            }
        }
    },
    methods:  {
        loadSlides(language) {
            console.log('Loading slides for language:', language);
        },
        loadSlides2(language) {
            console.log('Loading slides 2 for language:', language);
        },
        startSlideShow1() {
            console.log('Starting slideshow 1');
        },
        startSlideShow2() {
            console.log('Starting slideshow 2');
        },

        navigateToPage(url) {
            this.$router.push({ path: url });
        },

        openModal() {
            this.modalKey += 1;
            this.showModal = true;
        },
        closeModal() {
            this.showModal = false;
        },

        openWhatsApp() {
            window.open('https://wa.me/شماره-موبایل-شما', '_blank');
        },


        isEnglish(text) {
            return /^[A-Za-z\s]+$/.test(text);
        },
        scrollToAboutUs() {
            const aboutUsSection = document.getElementById('about-us');
            aboutUsSection.scrollIntoView({ behavior: 'smooth' });
        },
        scrollToCantactUs() {
            const aboutUsSection = document.getElementById('contact-us');
            aboutUsSection.scrollIntoView({ behavior: 'smooth' });
        },
        checkMobile() {
            this.isMobile = window.innerWidth <= 1180;

        },


        toggleFavorite(place) {
            place.isFavorite = !place.isFavorite;
            if (place.isFavorite) {
            } else {
            }},

        openSearchDialog() {
            this.searchDialog = true;
        },
        closeSearchDialog() {
            this.searchDialog = false;
            this.showMap = false;
        },

/*
        navigateToPanel() {
            switch (this.userRole) {
                case 'admin':
                    this.$router.push('/admin');
                    break;
                case 'host':
                    this.$router.push('/host');
                    break;
                case 'guest':
                    this.$router.push('/guest');
                    break;
            }
        },*/

        //banner
        viewMore(banner) {
            alert(banner.details);
        },
        updateButtonFontSize() {
            this.$forceUpdate();
        },

        beforeDestroy() {
            window.removeEventListener('resize', this.updateButtonFontSize);
            window.addEventListener('load', () => {
            });

        },

        t(key) {
            const keys = key.split('.');
            let result = this.translations[this.language] || {};
            for (let k of keys) {
                if (result[k] === undefined) {
                    console.error(`Missing translation for key: ${key}`);
                    return key;
                }
                result = result[k];
            }
            return result;
        },



        selectCategory(category) {
            if (this.selectedCategory === category) {
                this.showCategoryImages = !this.showCategoryImages;
            } else {
                this.selectedCategory = category;
                this.showCategoryImages = true;
            }
        },
        toggleLanguage() {
            this.language = this.language === 'fa' ? 'en' : 'fa';
            localStorage.setItem('language', this.language); // ذخیره زبان در LocalStorage
            this.loadSlides(this.language); // بارگذاری اسلایدها با زبان جدید
            this.loadSlides2(this.language);
        },

        searchHosts() {
            const results = [];

            Object.keys(this.categories).forEach(categoryKey => {
                const items = this.categories[categoryKey].items.filter(item =>
                    item.title.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
                    item.description.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
                    item.location.toLowerCase().includes(this.searchQuery.toLowerCase())
                );
                results.push(...items);
            });

            if (results.length) {
                this.selectedCategoryItems = results;
            } else {
                alert('نتیجه‌ای یافت نشد');
            }
        },

        initMap() {
            const map = L.map('map').setView([35.6892, 51.3890], 12);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
            }).addTo(map);

            const customIcon = L.icon({
                iconUrl: '/images/icon.png',
                iconSize: [25, 41],
                iconAnchor: [12, 41],
                popupAnchor: [1, -34],
                shadowSize: [41, 41]
            });

            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition((position) => {
                    const userLocation = [position.coords.latitude, position.coords.longitude];
                    L.marker(userLocation, { icon: customIcon }).addTo(map)
                        .bindPopup('شما اینجا هستید')
                        .openPopup();
                    map.setView(userLocation, 13);

                    const hostsLocations = [
                        { coords: [35.6892, 51.3890], title: "Host 1" },
                        { coords: [35.7156, 51.3347], title: "Host 2" }
                    ];

                    hostsLocations.forEach(host => {
                        const distance = map.distance(userLocation, host.coords) / 1000;
                        L.marker(host.coords, { icon: customIcon }).addTo(map)
                            .bindPopup(`${host.title} - فاصله: ${distance.toFixed(2)} کیلومتر`);
                    });
                });
            }
        }
    },
    watch: {
        showMap(newVal) {
            if (newVal) {
                this.$nextTick(() => {
                    this.initMap();
                });
            }
        }
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



        setTimeout(() => {
            this.isLoading = false;
        }, 1000);

        this.checkMobile();
        window.addEventListener('resize', this.checkMobile);

        const main3 = document.querySelector('.main3-container');
        if (main3) {
            main3.classList.add('fade-in');
        }


        window.addEventListener('resize', this.updateButtonFontSize);


        //theme
        const savedTheme = localStorage.getItem('theme');
        if (savedTheme) {
            this.isDark = savedTheme === 'dark';
        }

    },
    beforeDestroy() {
        window.removeEventListener('resize', this.checkMobile);
        window.removeEventListener('resize', this.updateButtonFontSize);
    },
};



</script>


<style scoped>

.loading-container {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 200px;
}

@media (max-width: 1180px) {
    .login-modal  {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
    }
}

.login-modal {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    background-color: rgba(0, 0, 0, 0.5);
    z-index: 10;
}

.mobile-layout .button-container11 {
    display: flex;
    flex-direction: column;
    align-items: center;
}

.desktop-layout .button-container11 {
    display: flex;
    flex-direction: row;
    justify-content: flex-start;
    gap: 10px;
}

.logo-container {
    position: absolute;
    top: 20px;
    left: 20px;
    z-index: 1000;
}

.logo {
    max-height: 150px;
    max-width: 200%;
}

@media (max-width: 600px) {
    .logo {
        height: 70px;
        width: auto;
    }
}


.main-container {
    position: relative;
    margin: 10px;
    padding: 20px;
    background-color: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
    border-radius: 20px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.2);
    height: 100vh;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: flex-end;
    width: 100%;

}

v-app {
    background-color: black;
    color: white;
}
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}
.app-background {
    background-color: black;
    color: white;
    margin: 0;
    padding: 0;
    min-height: 100vh;
    box-sizing: border-box;
}

html, body {
    margin: 0;
    padding: 0;
    height: 100%;
    background-color: black;
    color: white;
}


.main2-container {
    width: 66.66%;
    height: 100vh;
    padding: 20px;
    background-color: rgba(255, 255, 255, 0.1);
    border-radius: 30px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.2);
    backdrop-filter: blur(10px);
    position: relative;
    overflow: hidden;
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    flex-wrap: wrap;

}

.main2-container::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: url('../../../public/images/25.jpg') no-repeat center center;
    background-size: cover;

}

.button1-container, .buttons2-container {
    display: flex;
    gap: 10px;
    align-items: center;
    padding: 10px;
}

.button1-container {
    justify-content: flex-end;
    border-radius: 20px;
    margin-top: 10px;
}

.buttons2-container {
    justify-content: flex-start;
    border-radius: 30px;
    backdrop-filter: blur(15px);
    margin-top: 10px;
}

.equal-btn {
    background-color: transparent;
    border: 1px saddlebrown;
    color: white;
    min-width: 100px;
    font-size: 16px;
    padding: 12px 16px;
}



@media (max-width: 1180px) {
    .equal-btn{
        min-width: 100%;
        font-size: 16px;
        padding: 12px 16px;
    }

    .hamburger-menu {
        display: flex;
        justify-content: flex-end;
        width: 100%;
    }

    .hamburger-drawer {
        width: 250px;
        background-color: rgba(255, 255, 255, 0.1);
        position: fixed;
        right: 0;
        top: 0;
        height: 100vh;
        z-index: 1000;
        text-align: right;
    }

    .button1-container, .buttons2-container {
        flex-direction: column;
    }
}
@media (max-width: 600px) {
    .main2-container {
        justify-content: center;

    }

    .buttons2-container, .button1-container {
        justify-content: center;
    }
}

@media (min-width: 769px) and (max-width: 1024px) {
    .main2-container {
        justify-content: center;

    }

    .buttons2-container, .button1-container {
        justify-content: center;
    }
}
.search-dialog  {
    border-radius: 15px;
}

.search-container {
    position: relative;
    background-color: rgba(255, 255, 255, 0.7);
    border-radius: 10px;
    padding: 10px;
    backdrop-filter: blur(10px);
}
.search-bar input {
    background-color: transparent;
    color: black;
}
#map {
    height: 400px;
    width: 100%;
    border-radius: 15px;

}
.category-col {
    display: flex;
    flex-direction: column;
    align-items: center;
    margin-bottom: 20px;
}

.categories-slider {
    padding: 20px 0;
    background-color: transparent;
    display: flex;
    flex-direction: column;
    justify-content: flex-start;
}

.categories-slider [data-aos] {
    opacity: 0;
    transform: translateY(20px);
    transition: opacity 0.6s ease-out, transform 0.6s ease-out;
}

.categories-slider [data-aos].aos-animate {
    opacity: 1;
    transform: translateY(0);
}

.category-image {
    width: 100px;
    cursor: pointer;
    transition: transform 0.3s ease-in-out;
    border-radius: 50%;
    background-color: rgba(255, 255, 255, 0.4); /* پس‌زمینه شیشه‌ای (نیمه‌شفاف) */
    border-color: black;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    transition: transform 0.3s ease-in-out;
    max-width: 100px;
    height: auto;
    margin: 0 auto;
}

.category-image:hover {
    transform: scale(1.1);
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
    background-color: orange;
}

.category-btn {
    border-radius: 30px;
    background-color: rgba(255, 255, 255, 0.4);
    border-color: black;
    color: black;
    transition: background-color 0.3s ease-in-out, transform 0.3s ease-in-out;
    max-width: 150px;
    width: 100%;
    margin-top: 10px;
}

.category-btn:hover {
    background-color: orange;
    transform: translateY(-5px);
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
}

@media (min-width: 1025px) {
    .categories-slider {
        padding-top: 80px;
        margin-top: 0;
    }
    .category-col {
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .category-btn-english {
        font-size: 11px;
    }

}

@media (max-width: 600px) {
    .category-col {
        display: flex;
        flex-direction: column;
        align-items: center;
        padding: 0 5px;
    }
    .v-row {
        flex-direction: row;
    }
    .categories-slider {
        padding-top: 50px;
    }
    .category-image {
        width: 60px;
        height: 60px;
    }
    .category-btn {
        color: black;
        padding: 6px 12px;
        font-size: 11px;
        max-width: none;
        width: 100%;
    }
    .category-btn-english {
        font-size: 7px;
    }
    .email p {
        margin: 0;
        font-size: 10px;
        font-weight: bold;
        color:white ;
    }

    .social-icons {
        display: flex;
        gap: 10px;
        margin-top: 10px;
        color:white ;

    }

}

.button-container11 {
    position: fixed;
    padding-top: 20px;
    top: 15%;
    right: 20px;
    transform: translateY(-50%);
    display: flex;
    flex-direction: column;
    gap: 10px;
    z-index: 1000;
    justify-content: flex-start;
    flex-wrap: wrap;
    gap: 10px;
}
@media (max-width: 1180px) {
    .button-container {
        flex-direction: column;
        align-items: center;
    }
}
.square-button {
    width: 100px;
    height: 100px;
    background-color: rgba(255, 255, 255, 0.4);
    border: 2px solid #FFA500;
    color: black;
    border-radius: 10px;
    padding: 10px 20px;
    font-size: 16px;
    cursor: pointer;
    overflow: hidden;
    transition: background-color 0.3s ease, transform 0.3s ease;
}

.square-button:hover {
    background-color: orange;
    transform: scale(1.05);
}


@media (max-width: 961px) {
    .button-container11{
        padding-top: 5px;
        top: 30%;

    }
    .square-button {

        width: 70px;
        height: 70px;
        font-size:10px;
        text-align: center;
    }


}
body {
    margin: 0;
    font-family: Arial, sans-serif;
}

.category-image, .logo, .main2-container, .button-container11,
.categories-slider, .equal-btn1, .equal-btn, .category-btn,
.square-button {
    opacity: 0;
    transform: translateY(50px) scale(0.9);
    animation-duration: 1.5s;
    animation-fill-mode: forwards;
}

@keyframes fadeInUp {
    0% {
        opacity: 0;
        transform: translateY(50px) scale(0.9);
    }
    60% {
        opacity: 1;
        transform: translateY(-10px) scale(1.05);
    }
    100% {
        opacity: 1;
        transform: translateY(0) scale(1);
    }
}

.category-image, .main2-container, .button-container11,
.categories-slider, .equal-btn1, .equal-btn,
.category-btn, .square-button {
    animation-name: fadeInUp;
    animation-delay: 0.5s;
}

.logo {
    animation-name: fadeInUp;
    animation-delay: 0.7s;
}

.logo-container {
    margin-bottom: auto;
}

.contact-info {
    position: absolute;
    bottom: 250px;
    left: 20px;
    display: flex;
    flex-direction: column;
}

.email p {
    margin: 0;
    font-size: 20px;
    font-weight: bold;
    color:white ;
}

.social-icons {
    display: flex;
    gap: 20px;
    margin-top: 10px;
    color:white ;

}

.social-icon {
    font-size: 24px;
    cursor: pointer;
    transition: transform 0.3s ease;
}
@media (max-width: 961px) {

    .email p {
        margin: 0;
        font-size: 10px;
        font-weight: bold;
        color:white ;
    }

    .social-icons {
        display: flex;
        gap: 10px;
        margin-top: 10px;
        color:white ;

    }
    .social-icon {
        font-size: 12px;
        cursor: pointer;
        transition: transform 0.3s ease;
    }

}

.social-icon:hover {
    transform: scale(1.2);
}

.banner-slideshow {
    position: absolute;
    bottom: 20px;
    left: 5px;
    width: calc(100% - 200px);
    height: calc(100% - 50px);
    background-color: rgba(0, 0, 0, 0.5);
    border-radius: 20%;
    padding-top: 500px;
    padding-right: 700px;

}

.banner-image {
    width: 100%;
    height: auto;
    object-fit: cover;
    border-radius: 8px;
}

.banner-text {
    position: absolute;
    bottom: 10px;
    left: 10px;
    color: white;
    text-shadow: 1px 1px 5px rgba(0, 0, 0, 0.7);
}

@media (max-width: 600px) {
    .contact-info {
        left: 10px;
    }



    .banner-image {
        height: 80px;
    }
    .banner-slideshow {
        position: absolute;
        bottom: 60px;
        left: 40px;
        width: calc(100% );
        background-color: rgba(0, 0, 0, 0.5);
        border-radius: 20%;
        height: auto;
        padding-top: 120px;
        padding-right: 190px;


    }

}
.v-container {
    margin-top: 10px;
}
.my-slideshow-container {
    background-color: inherit;
}

.my-slideshow .v-carousel-item {
    position: relative;
}

.banner-image {
    width: 50%;

}
.banner-image + .v-btn {
    width: 25%;
}

@media (max-width: 600px) {
    .banner-image {
        width: 70%;
    }
}
.banner-image + .v-btn {
    width: 25%;
    margin: 0 auto;
}

.v-btn:hover {
    transform: scale(1.1);
    transition: transform 0.3s ease-in-out, background-color 0.3s ease-in-out;
    background-color: #FFCC00 !important; /* رنگ پس‌زمینه تغییر یافته */
}

.category-image:hover {
    transform: scale(1.1);
    transition: transform 0.3s ease-in-out;
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
}
.categories-slider [data-aos] {
    opacity: 0;
    transform: translateY(20px);
    transition: opacity 0.6s ease-out, transform 0.6s ease-out;
}
.categories-slider [data-aos].aos-animate {
    opacity: 1;
    transform: translateY(0);
}
.my-slideshow .v-carousel-item {
    transition: transform 0.5s ease-in-out;
}
.my-slideshow .v-carousel-item:hover {
    transform: scale(1.05) rotate(1deg);
}
.v-app {
    animation: fadeIn 1s ease-in-out;
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.featured-listing-swiper {
    width: 100%;
    height: 100%;
}

.featured-listing-swiper .swiper-slide {
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;

}

.image {
    width: 100%;
    height: auto;
    object-fit: cover;
}
.hover-title {
    margin: 0;
}

.favorite-button {
    color: red;
}


.main3-container {
    position: relative;
    width: 100%;
    background-color: rgba(0, 0, 0, 0.9);
    border-radius: 30px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    padding: 20px;
    margin-top: 20px;
    overflow: hidden;
    animation: slideIn 1s ease-out;
}


.main2-container {
    margin-bottom: 40px; /* افزایش فاصله از پایین */

}

@keyframes slideIn {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}


@keyframes fadeIn {
    from {
        opacity: 0;
    }
    to {
        opacity: 1;
    }
}

.fade-in {
    animation: fadeIn 1s ease-out;
}

.featured-listing-swiper .swiper-slide .image {
    width: 90%;
    height: auto;
    margin: 0 auto;
    padding-left: 10px;
    padding-right: 10px;
}


.about-us-container {
    padding: 100px 20px;
    background-color: #f5f5f5;
    position: relative;
}

.about-us-content {
    display: flex;
    align-items: center;
    justify-content: space-between;
    animation: fadeInUp 1s ease-out;
}

.about-us-text {
    padding: 20px;
}

.about-us-lottie {
    display: flex;
    justify-content: center;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
body {
    background-color: black;
    margin: 0;
    padding: 0;
    overflow-x: hidden;

}
html, body {
    overflow-x: hidden;
    background-color: black;
}
.main-container, .v-app {
    background-color: black;
    margin: 0;
    padding: 0;
}
.HostAdَ{
    background-color: black;
    width: auto;
    height: auto;
    padding-right: 20px;
}
.mb-4{
    margin-bottom: 16px;
    padding-left: 8px;
    padding-right: 8px;
    background-color: rgba(255, 255, 255, 0.4);
}
.hover-title2 {
    font-size: 14px;
    margin-left: 10px;
}

.favorite-button {
    margin-right: 10px;
    background-color: transparent;
    pointer-events: auto;
    z-index: 20;

}

.v-card-actions {
    padding: 8px 16px;
}

.about-us-container {
    padding: 100px 20px;
    background-color: #f5f5f5;
    position: relative;
}

.about-us-content {
    display: flex;
    align-items: center;
    justify-content: space-between;
    animation: fadeInUp 1s ease-out;
}

.about-us-text {
    padding: 20px;
}

.about-us-lottie {
    display: flex;
    justify-content: center;
}
.my-12 {
    margin-top: 3rem;
    margin-bottom: 3rem;
}

.logo-style {
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5);
    transition: transform 0.3s ease;
}

.logo-style:hover {
    transform: scale(1.1);
}
.whatsapp-float {
    position: fixed;
    bottom: 20px;
    right: 20px;
    z-index: 1000;
}

.whatsapp-link {
    display: flex;
    justify-content: center;
    align-items: center;
    width: 50px;
    height: 50px;
    background-color: #25D366;
    color: white;
    border-radius: 50%;
    text-align: center;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
    text-decoration: none;
}

.whatsapp-icon {
    font-size: 24px;
    color: white;
}
.social-icons2 {
    display: flex;
    justify-content: center;
    gap: 20px;
    margin-top: 20px;
}

.social-icon2 {
    font-size: 36px;
    color: white;
    transition: transform 0.3s ease, color 0.3s ease;
    cursor: pointer;
}

.social-icons2 a:hover .social-icon2 {
    transform: scale(1.2);
    color: #00ff00;
}

.social-icon2 {
    text-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.login-modal-app-bar {
    z-index: 1100;
}

.v-navigation-drawer {
    z-index: 1000;
}
.login-modal-app-bar {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
}
@media (max-width: 600px) {
    .login-modal-app-bar {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        z-index: 1100;
    }
}

</style>
