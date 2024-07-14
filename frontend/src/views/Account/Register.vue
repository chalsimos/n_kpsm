<template>
<section class="register-wizard bg-cover bg-center min-h-screen flex items-center justify-center">
    <div class="flex items-center justify-center h-screen w-full">
        <a-card class="custom-card rounded-lg p-5 shadow-md h-6/6 md:w-[25vw] mx-auto">
            <div class="text-center mb-4">
                <img class="w-20 mx-auto" src="../../assets/kpms.png" alt="logo" />
                <h4 class="text-xl text-orange-600 font-semibold">KPSM</h4>
            </div>
            <a-form @submit.prevent="handleSubmit" layout="vertical">
                <a-row v-if="currentStep === 0">
                    <div class="grid md:grid-cols-2 md:gap-2 whitespace-nowrap">
                        <div class="mb-3">
                            <label for="FirstName" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">First Name</label>
                            <input v-model="firstname" type="text" id="FirstName" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full md:w-[10vw] p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-orange-500 dark:focus:border-orange-500" placeholder="Juan" required />
                        </div>
                        <div class="mb-3">
                            <label for="MiddleName" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Middle Name</label>
                            <input v-model="middlename" type="text" id="MiddleName" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full md:w-[10vw] p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-orange-500 dark:focus:border-orange-500" placeholder="Martinez" required />
                        </div>
                        <div class="mb-3">
                            <label for="LastName" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Last Name</label>
                            <input v-model="lastname" type="text" id="LastName" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full md:w-[10vw] p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-orange-500 dark:focus:border-orange-500" placeholder="Dela Cruz" required />
                        </div>
                        <div class="mb-3">
                            <label for="Gender" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Gender</label>
                            <select v-model="gender " id="Gender" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full md:w-[10vw] p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-orange-500 dark:focus:border-orange-500">
                                <option value="" disabled selected>Choose Gender</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="Birthday" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Birthday</label>
                            <div class="relative max-w-full">
                                <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                                    </svg>
                                </div>
                                <input v-model="birthday" @input="calculateAge" id="Birthday" type="text" class="bg-gray-50 border  border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full ps-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-orange-500 dark:focus:border-orange-500" placeholder="Select date">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="Age" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Age</label>
                            <input v-model="age" readonly type="number" id="Age" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full md:w-[10vw] p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-orange-500 dark:focus:border-orange-500" required />
                        </div>
                    </div>
                </a-row>
                <a-row v-if="currentStep === 1">
                    <div class="grid md:grid-cols-2 md:gap-2 whitespace-nowrap">
                        <div class="mb-3">
                            <label for="ContactNumber" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Contact Number</label>
                            <input v-model="contactnumber" type="number" id="ContactNumber" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full md:w-[10vw] p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-orange-500 dark:focus:border-orange-500" placeholder="09123456789" required />
                        </div>
                        <div class="mb-3">
                            <label for="Province" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Province</label>
                            <select @change="handleCity" id="Province" v-model="provinceto" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full md:w-[10vw] p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-orange-500 dark:focus:border-orange-500" required>
                                <option value="1752">Oriental Mindoro</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="Municipality" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Municipality</label>
                            <select @change="handleBarangay" id="Municipality" v-model="municipality" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full md:w-[10vw] p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-orange-500 dark:focus:border-orange-500" required>
                                <option disabled selected value="">Select City</option>
                                <option v-for="city in cities" :value="city.city_code" :key="city.city_code">{{ city.city_name }}</option>
                            </select>
                        </div>
                        <input type="hidden" v-model="selectedMunicipality" id="SelectedMunicipality" readonly>
                        <input type="hidden" v-model="selectedBarangay" id="SelectedBarangay" readonly>
                        <div class="mb-3">
                            <label for="Barangay" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Barangay</label>
                            <select id="Barangay" v-model="barangay" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full md:w-[10vw] p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-orange-500 dark:focus:border-orange-500" required>
                                <option disabled>Select Barangay</option>
                                <option v-for="barangay in barangays" :value="barangay.brgy_code" :key="barangay.brgy_code">{{ barangay.brgy_name }}</option>
                            </select>
                        </div>
                    </div>
                </a-row>
                <a-row v-if="currentStep === 2">
                    <div class="grid md:grid-cols-2 md:gap-2 whitespace-nowrap">
                        <div class="mb-3">
                            <label for="username" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Username</label>
                            <input v-model="username" type="text" id="username" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full md:w-[10vw] p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-orange-500 dark:focus:border-orange-500" placeholder="Username" required />
                        </div>
                        <div class="mb-3">
                            <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email</label>
                            <input type="email" id="email" v-model="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full md:w-[10vw] p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-orange-500 dark:focus:border-orange-500" placeholder="name@gmail.com" required />
                        </div>
                        <div class="mb-3">
                            <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password</label>
                            <input type="password" id="password" v-model="password" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full md:w-[10vw] p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-orange-500 dark:focus:border-orange-500" required />
                        </div>
                        <div class="mb-3">
                            <label for="confirmPassword" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Confirm Password</label>
                            <input type="password" id="confirmPassword" v-model="confirmPassword" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full md:w-[10vw] p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-orange-500 dark:focus:border-orange-500" required />
                        </div>
                    </div>
                </a-row>
                <a-form-item v-if="currentStep === 2">
                    <a-form-item v-if="currentStep === 2">
                        <a-checkbox required v-model="termsAccepted">
                            <div class="flex flex-col md:flex-row items-start md:items-center">
                                <span class="whitespace-normal">I agree with the</span>
                                <router-link to="#" @click.prevent="showTermsModal" class="whitespace-normal md:ml-1 md:mt-0">Terms and Conditions</router-link>
                            </div>
                        </a-checkbox>
                    </a-form-item>
                </a-form-item>
                <div class="button-container flex justify-end absolute bottom-0 left-0 right-0 pb-3 px-5">
                    <button v-if="currentStep === 0" class=" px-1.5 py-1.5 ml-5 sm:w-[8vw] bg-green-500 text-white left-0 absolute top-0 hover:bg-green-600 focus:bg-green-600 active:bg-green-700 rounded" @click="navigateToLogin">
                        Already Have Account
                    </button>
                    <a-button class="mr-1" type="default" v-if="currentStep > 0" @click="prevStep">Previous</a-button>
                    <a-button v-if="currentStep < 2" type="primary" @click="nextStep">Next</a-button>
                    <button v-if="currentStep === 2" type="submit" class="w-full sm:w-[5vw] bg-blue-500 text-white hover:bg-blue-600 focus:bg-blue-600 active:bg-blue-700 rounded">
                        Register
                    </button>
                </div>
            </a-form>
        </a-card>
    </div>
    <a-modal v-model:visible="termsModalVisible" title="Terms and Conditions" footer="">
        <h2><strong>Terms and Conditions</strong></h2>
        <p>Welcome to KPSM!</p>
        <p>These terms and conditions outline the rules and regulations for the use of KPSM's Website, located at https://kpsm.online/.</p>
        <p>By accessing this website we assume you accept these terms and conditions. Do not continue to use KPSM if you do not agree to take all of the terms and conditions stated on this page.</p>
        <p>The following terminology applies to these Terms and Conditions, Privacy Statement and Disclaimer Notice and all Agreements: "Client", "You" and "Your" refers to you, the person log on this website and compliant to the Company's terms and conditions. "The Company", "Ourselves", "We", "Our" and "Us", refers to our Company. "Party", "Parties", or "Us", refers to both the Client and ourselves. All terms refer to the offer, acceptance and consideration of payment necessary to undertake the process of our assistance to the Client in the most appropriate manner for the express purpose of meeting the Client's needs in respect of provision of the Company's stated services, in accordance with and subject to, prevailing law of ph. Any use of the above terminology or other words in the singular, plural, capitalization and/or he/she or they, are taken as interchangeable and therefore as referring to same.</p>
        <h3><strong>Cookies</strong></h3>
        <p>We employ the use of cookies. By accessing KPSM, you agreed to use cookies in agreement with the KPSM's Privacy Policy. </p>
        <p>Most interactive websites use cookies to let us retrieve the user's details for each visit. Cookies are used by our website to enable the functionality of certain areas to make it easier for people visiting our website. Some of our affiliate/advertising partners may also use cookies.</p>
        <h3><strong>License</strong></h3>
        <p>Unless otherwise stated, KPSM and/or its licensors own the intellectual property rights for all material on KPSM. All intellectual property rights are reserved. You may access this from KPSM for your own personal use subjected to restrictions set in these terms and conditions.</p>
        <p>You must not:</p>
        <ul>
            <li>Republish material from KPSM</li>
            <li>Sell, rent or sub-license material from KPSM</li>
            <li>Reproduce, duplicate or copy material from KPSM</li>
            <li>Redistribute content from KPSM</li>
        </ul>
        <p>This Agreement shall begin on the date hereof. Our Terms and Conditions were created with the help of the <a href="https://www.termsandconditionsgenerator.com/">Free Terms and Conditions Generator</a>.</p>
        <p>Parts of this website offer an opportunity for users to post and exchange opinions and information in certain areas of the website. KPSM does not filter, edit, publish or review Comments prior to their presence on the website. Comments do not reflect the views and opinions of KPSM,its agents and/or affiliates. Comments reflect the views and opinions of the person who post their views and opinions. To the extent permitted by applicable laws, KPSM shall not be liable for the Comments or for any liability, damages or expenses caused and/or suffered as a result of any use of and/or posting of and/or appearance of the Comments on this website.</p>
        <p>KPSM reserves the right to monitor all Comments and to remove any Comments which can be considered inappropriate, offensive or causes breach of these Terms and Conditions.</p>
        <p>You warrant and represent that:</p>
        <ul>
            <li>You are entitled to post the Comments on our website and have all necessary licenses and consents to do so;</li>
            <li>The Comments do not invade any intellectual property right, including without limitation copyright, patent or trademark of any third party;</li>
            <li>The Comments do not contain any defamatory, libelous, offensive, indecent or otherwise unlawful material which is an invasion of privacy</li>
            <li>The Comments will not be used to solicit or promote business or custom or present commercial activities or unlawful activity.</li>
        </ul>
        <p>You hereby grant KPSM a non-exclusive license to use, reproduce, edit and authorize others to use, reproduce and edit any of your Comments in any and all forms, formats or media.</p>
        <h3><strong>Hyperlinking to our Content</strong></h3>
        <p>The following organizations may link to our Website without prior written approval:</p>
        <ul>
            <li>Government agencies;</li>
            <li>Search engines;</li>
            <li>News organizations;</li>
            <li>Online directory distributors may link to our Website in the same manner as they hyperlink to the Websites of other listed businesses; and</li>
            <li>System wide Accredited Businesses except soliciting non-profit organizations, charity shopping malls, and charity fundraising groups which may not hyperlink to our Web site.</li>
        </ul>
        <p>These organizations may link to our home page, to publications or to other Website information so long as the link: (a) is not in any way deceptive; (b) does not falsely imply sponsorship, endorsement or approval of the linking party and its products and/or services; and (c) fits within the context of the linking party's site.</p>
        <p>We may consider and approve other link requests from the following types of organizations:</p>
        <ul>
            <li>commonly-known consumer and/or business information sources;</li>
            <li>dot.com community sites;</li>
            <li>associations or other groups representing charities;</li>
            <li>online directory distributors;</li>
            <li>internet portals;</li>
            <li>accounting, law and consulting firms; and</li>
            <li>educational institutions and trade associations.</li>
        </ul>
        <p>We will approve link requests from these organizations if we decide that: (a) the link would not make us look unfavorably to ourselves or to our accredited businesses; (b) the organization does not have any negative records with us; (c) the benefit to us from the visibility of the hyperlink compensates the absence of KPSM; and (d) the link is in the context of general resource information.</p>
        <p>These organizations may link to our home page so long as the link: (a) is not in any way deceptive; (b) does not falsely imply sponsorship, endorsement or approval of the linking party and its products or services; and (c) fits within the context of the linking party's site.</p>
        <p>If you are one of the organizations listed in paragraph 2 above and are interested in linking to our website, you must inform us by sending an e-mail to KPSM. Please include your name, your organization name, contact information as well as the URL of your site, a list of any URLs from which you intend to link to our Website, and a list of the URLs on our site to which you would like to link. Wait 2-3 weeks for a response.</p>
        <p>Approved organizations may hyperlink to our Website as follows:</p>
        <ul>
            <li>By use of our corporate name; or</li>
            <li>By use of the uniform resource locator being linked to; or</li>
            <li>By use of any other description of our Website being linked to that makes sense within the context and format of content on the linking party's site.</li>
        </ul>
        <p>No use of KPSM's logo or other artwork will be allowed for linking absent a trademark license agreement.</p>
        <h3><strong>iFrames</strong></h3>
        <p>Without prior approval and written permission, you may not create frames around our Webpages that alter in any way the visual presentation or appearance of our Website.</p>
        <h3><strong>Content Liability</strong></h3>
        <p>We shall not be hold responsible for any content that appears on your Website. You agree to protect and defend us against all claims that is rising on your Website. No link(s) should appear on any Website that may be interpreted as libelous, obscene or criminal, or which infringes, otherwise violates, or advocates the infringement or other violation of, any third party rights.</p>
        <h3><strong>Reservation of Rights</strong></h3>
        <p>We reserve the right to request that you remove all links or any particular link to our Website. You approve to immediately remove all links to our Website upon request. We also reserve the right to amen these terms and conditions and it's linking policy at any time. By continuously linking to our Website, you agree to be bound to and follow these linking terms and conditions.</p>
        <h3><strong>Removal of links from our website</strong></h3>
        <p>If you find any link on our Website that is offensive for any reason, you are free to contact and inform us any moment. We will consider requests to remove links but we are not obligated to or so or to respond to you directly.</p>
        <p>We do not ensure that the information on this website is correct, we do not warrant its completeness or accuracy; nor do we promise to ensure that the website remains available or that the material on the website is kept up to date.</p>
        <h3><strong>Disclaimer</strong></h3>
        <p>To the maximum extent permitted by applicable law, we exclude all representations, warranties and conditions relating to our website and the use of this website. Nothing in this disclaimer will:</p>
        <ul>
            <li>limit or exclude our or your liability for death or personal injury;</li>
            <li>limit or exclude our or your liability for fraud or fraudulent misrepresentation;</li>
            <li>limit any of our or your liabilities in any way that is not permitted under applicable law; or</li>
            <li>exclude any of our or your liabilities that may not be excluded under applicable law.</li>
        </ul>
        <p>The limitations and prohibitions of liability set in this Section and elsewhere in this disclaimer: (a) are subject to the preceding paragraph; and (b) govern all liabilities arising under the disclaimer, including liabilities arising in contract, in tort and for breach of statutory duty.</p>
        <p>As long as the website and the information and services on the website are provided free of charge, we will not be liable for any loss or damage of any nature.</p>
        <a-button type="primary" @click="acceptTerms">I Accept</a-button>
    </a-modal>
</section>
</template>

<script>
import Flatpickr from 'flatpickr';
import 'flatpickr/dist/flatpickr.min.css';
import axios from '../../main.js';
import {
    Form,
    Input,
    Button,
    Alert,
    Card,
    Row,
    Col,
    Select,
    DatePicker,
    Checkbox,
    Modal,
} from "ant-design-vue";
import {
    ref
} from 'vue';

import {
    useToast
} from 'vue-toastification'
import SelectPhilippinesAddress from 'select-philippines-address';
const toastr = useToast()
import {
    cities,
    barangays
} from 'select-philippines-address';
export default {
    data() {
        return {
            provinces: [],
            cities: [],
            barangays: [],
            provinceto: '1752',
            municipality: null,
            barangay: null,
            province: "Oriental Mindoro",
            selectedMunicipality: '',
            selectedBarangay: '',
            currentStep: 0,
            username: "",
            email: "",
            password: "",
            confirmPassword: "",
            firstname: "",
            middlename: "",
            lastname: "",
            gender: "",
            birthday: null,
            age: "",
            contactnumber: "",
            termsAccepted: false,
            termsModalVisible: false,
            error: null,
        };
    },
    components: {
        SelectPhilippinesAddress,
        'a-form': Form,
        'a-form-item': Form.Item,
        'a-input': Input,
        'a-button': Button,
        'a-alert': Alert,
        'a-card': Card,
        'a-row': Row,
        'a-col': Col,
        'a-select': Select,
        'a-select-option': Select.Option,
        'a-date-picker': DatePicker,
        'a-checkbox': Checkbox,
        'a-modal': Modal,
    },
    mounted() {
        initFlowbite();
        this.fetchCities();
        Flatpickr('#Birthday', {});
    },
    methods: {
        async handleSubmit() {
            if (this.password !== this.confirmPassword) {
                this.error = "Passwords do not match.";
                return;
            }
            try {
                const response = await axios.post("/api/register", {
                    username: this.username,
                    email: this.email,
                    password: this.password,
                    firstname: this.firstname,
                    middlename: this.middlename,
                    lastname: this.lastname,
                    gender: this.gender,
                    age: this.age,
                    birthday: this.birthday,
                    contactnumber: this.contactnumber,
                    province: this.province,
                    municipality: this.selectedMunicipality,
                    barangay: this.selectedBarangay,
                });
                console.log("Registration response:", response);
                if (response.status === 201) {
                    this.$router.push("/");
                } else {
                    console.error("Registration failed");
                }
            } catch (error) {
                console.error("Registration error:", error);
                if (error.response && error.response.data && error.response.data.error) {
                    this.error = error.response.data.error;
                } else {
                    this.error = "Registration failed. Please try again.";
                }
            }
        },
        navigateToLogin() {
            this.$router.push("/login");
        },
        nextStep() {
            this.currentStep++;
        },
        prevStep() {
            this.currentStep--;
        },
        showTermsModal() {
            this.termsModalVisible = true;
        },
        acceptTerms() {
            this.termsModalVisible = false;
            this.termsAccepted = true;
        },
        updateAge(date) {
            const today = new Date();
            const birthDate = new Date(date);
            let age = today.getFullYear() - birthDate.getFullYear();
            const m = today.getMonth() - birthDate.getMonth();
            if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
                age--;
            }
            this.age = age;
        },
        fetchCities() {
            cities(this.provinceto)
                .then(response => {
                    if (response && response.length > 0) {
                        this.cities = response;
                        this.municipality = null;
                        this.handleBarangay();
                    } else {
                        console.error('Empty response received for cities.');
                    }
                })
                .catch(error => {
                    console.error('Error fetching cities:', error);
                });
        },
        handleBarangay() {
            if (!this.municipality) return;
            barangays(this.municipality)
                .then(response => {
                    this.barangays = response;
                    const selectedCity = this.cities.find(city => city.city_code === this.municipality);
                    this.selectedMunicipality = selectedCity ? selectedCity.city_name : '';
                    this.selectedBarangay = this.barangays.length > 0 ? this.barangays[0].brgy_name : '';
                })
                .catch(error => {
                    console.error('Error fetching barangays:', error);
                });
        },
        calculateAge() {
            if (!this.birthday) return;
            const today = new Date();
            const birthDate = new Date(this.birthday);
            let age = today.getFullYear() - birthDate.getFullYear();
            const monthDiff = today.getMonth() - birthDate.getMonth();
            if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
                age--;
            }
            this.age = age;
        },
    },
    watch: {
        barangay(newBarangay) {
            const selectedBarangayObject = this.barangays.find(barangay => barangay.brgy_code === newBarangay);
            this.selectedBarangay = selectedBarangayObject ? selectedBarangayObject.brgy_name : '';
        },
        hospital(newVal) {
            this.updateSelectedHospitalOffers(newVal);
            this.typeOfRequest = '';
        },
    },
};
</script>

<style scoped>
@media only screen and (min-width: 1024px) {
    .register-wizard {
        background-image: url('../../assets/congPA.jpg');
        background-size: 50%;
    }

    .custom-card {
        margin-top: 45vh;
        background-color: rgba(255, 255, 255, 0.5);
        backdrop-filter: blur(5px);
    }
}

.custom-card {
    background-color: rgba(255, 255, 255, 0.5);
    backdrop-filter: blur(5px);
}
</style>
