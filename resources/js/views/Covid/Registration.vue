<template>
    <div>
        <div class="wrapper-page">
            <div class="card overflow-hidden account-card mx-3">
                <div class="bg-gradient p-4 text-white text-center position-relative">
                    <h4 class="font-25 m-b-5">WELCOME TO COVID VACCINE REGISTRATION </h4>
                </div>
                <div class="account-card-content">
                    <ValidationObserver v-slot="{ handleSubmit }">
                        <form class="form-horizontal m-t-30" @submit.prevent="handleSubmit(onSubmit)">
                            <div class="form-group">
                                <label for="Appointment">Appointment Day</label>

                                <vuejs-datepicker
                                    @input="checkVaccineLimit()"
                                    v-model="selectedAppointmentDate"
                                    :disabled-dates="disabledDates"
                                    :highlighted="highlightedDays"
                                    :bootstrap-styling="true"
                                />
                            </div>
                            <ValidationProvider name="Vaccine Center" mode="eager" rules="required" v-slot="{ errors }">
                                <div class="form-group">
                                    <label for="VaccineCenter">Vaccine Center <span class="error">*</span></label>
                                    <multiselect v-model="vaccineCenter"
                                                 :options="vaccineCenters"
                                                 @input="checkVaccineLimit()"
                                                 :multiple="false"
                                                 :close-on-select="true"
                                                 :clear-on-select="false"
                                                 :preserve-search="true"
                                                 placeholder="Vaccine Center Name"
                                                 label="VaccineCenterName" track-by="VaccineCenterCode">

                                    </multiselect>
                                    <span class="error-message">{{ errors[0] }}</span>
                                </div>
                            </ValidationProvider>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="fullName">Already Booked</label>
                                        <input type="number" readonly class="form-control" id="alreadyBooked"
                                               v-model="alreadyBooked" name="alreadyBooked">
                                    </div>

                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="fullName">Available</label>
                                        <input type="number" readonly class="form-control" id="available"
                                               v-model="available" name="available">
                                    </div>

                                </div>
                            </div>

                            <ValidationProvider name="Full Name" mode="eager" rules="required" v-slot="{ errors }">
                                <div class="form-group">
                                    <label for="fullName">Full Name <span class="error">*</span></label>
                                    <input type="text" class="form-control" :class="{'error-border': errors[0]}"
                                           id="fullName"
                                           v-model="fullName" name="fullName" placeholder="Full Name"
                                           autocomplete="off">
                                    <span class="error-message"> {{ errors[0] }}</span>
                                </div>
                            </ValidationProvider>


                            <div class="row">
                                <div class="col-md-4">
                                    <ValidationProvider name="Age" mode="eager" rules="required" v-slot="{ errors }">
                                        <div class="form-group">
                                            <label for="user-password">Age <span class="error">*</span></label>
                                            <input type="number" min="10" v-model="age" class="form-control"
                                                   :class="{'error-border': errors[0]}"
                                                   id="age" placeholder="Age" autocomplete>
                                            <span class="error-message">{{ errors[0] }}</span>
                                        </div>
                                    </ValidationProvider>
                                </div>

                                <div class="col-md-8">
                                    <ValidationProvider name="Email" mode="eager" rules="required" v-slot="{ errors }">
                                        <div class="form-group">
                                            <label for="user-password">Email <span class="error">*</span></label>
                                            <input type="email" v-model="email" class="form-control"
                                                   :class="{'error-border': errors[0]}"
                                                   id="email" placeholder="Email" autocomplete>
                                            <span class="error-message">{{ errors[0] }}</span>
                                        </div>
                                    </ValidationProvider>
                                </div>


                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <ValidationProvider name="NID" mode="eager" rules="required|min:6"
                                                        v-slot="{ errors }">
                                        <div class="form-group">
                                            <label for="nid">NID <span class="error">*</span></label>
                                            <input type="number"
                                                   @input="checkNid($event)"
                                                   v-model="nid" class="form-control"
                                                   :class="{'error-border': errors[0]}"
                                                   id="nid" placeholder="NID" autocomplete>
                                            <span class="error-message">{{ errors[0] }}</span>
                                        </div>
                                    </ValidationProvider>
                                </div>

                                <div class="col-md-6">
                                    <ValidationProvider name="Phone" mode="eager" rules="required" v-slot="{ errors }">
                                        <div class="form-group">
                                            <label for="Phone">Phone <span class="error">*</span></label>
                                            <input type="tel" pattern='(01)?[0-9]{11}'
                                                   v-model="phone" class="form-control"
                                                   :class="{'error-border': errors[0]}"
                                                   id="phone" placeholder="Ex:01...." autocomplete>
                                            <span class="error-message">{{ errors[0] }}</span>
                                        </div>
                                    </ValidationProvider>
                                </div>
                            </div>


                            <submit-form name="Register"/>
                        </form>
                    </ValidationObserver>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import {Common} from '../../mixins/common'
import moment from "moment";
import Datepicker from 'vuejs-datepicker';

export default {
    mixins: [Common],
    components: {
        vuejsDatepicker: Datepicker
    },
    data() {
        return {
            disabledDates: {
                customPredictor: (date) => {
                    const today = new Date();
                    // Disable all dates that are not Monday or Tuesday or are in the past
                    const day = date.getDay();
                    return (day === 5 || day === 6) || date < today.setHours(0, 0, 0, 0);
                }
            },
            highlightedDays: {
                customPredictor: (date) => {
                    const day = date.getDay();
                    return day === 0 || day === 1 || day === 2 || day === 3 || day === 4;
                }
            },
            fullName: '',
            age: '',
            email: '',
            nid: '',
            phone: '',
            vaccineCenters: [],
            vaccineCenter: '',
            selectedAppointmentDate: '',
            alreadyBooked: 0,
            available: 0,
            errors: [],
            alreadyRegisteredNid: 0


        }
    },
    computed: {
        formattedDate() {
            if (!this.selectedAppointmentDate) return '';
            const date = new Date(this.selectedAppointmentDate);
            const year = date.getFullYear();
            const month = String(date.getMonth() + 1).padStart(2, '0'); // Months are zero-indexed
            const day = String(date.getDate()).padStart(2, '0');
            return `${year}-${month}-${day}`; // Format: YYYY-MM-DD
        }
    },
    mounted() {
        this.getSupportingData();
    },
    methods: {
        getSupportingData() {
            let instance = this;
            this.axiosGet('covid/registration-supporting-data', function (response) {
                instance.vaccineCenters = response.vaccineCenters;
            }, function (error) {

            });

        },
        checkVaccineLimit() {
            let instance = this;
            let vacCenterCode=  instance.vaccineCenter['VaccineCenterCode'];
            if (vacCenterCode && instance.formattedDate) {

                console.log(vacCenterCode)
                instance.errors = []
                this.axiosGet('covid/vaccine-center-capacity' + '/' + vacCenterCode + '/' + instance.formattedDate, function (response) {
                    let availableTemp = parseInt(parseInt(response.capactiy) - parseInt(response.alreadyBooked));
                    instance.available = availableTemp<=0?0 : availableTemp;

                    if (instance.available === 0) {
                        instance.errorNoti('Not Available For This Center! Try Another ');
                        instance.errors.push('error')
                        instance.selectedAppointmentDate = ''
                        instance.vaccineCenter = ''
                    } else {
                        instance.alreadyBooked = response.alreadyBooked;
                        instance.errors = []
                    }
                }, function (error) {

                });
            }
        },
        checkNid(val) {
            let instance = this;
            let nidNo = val.target.value
            if (nidNo.length > 5) {
                instance.errors = []
                instance.axiosGet('covid/registered-nid-check' + '/' + nidNo, function (response) {
                    instance.alreadyRegisteredNid = response.alreadyRegisteredNid;
                    if (parseInt(instance.alreadyRegisteredNid) > 0) {
                        instance.nid=''
                        instance.errors.push('error')
                        instance.errorNoti('Already Registered From This NID');
                    } else {
                        instance.errors = []
                    }

                }, function (error) {

                });
            }


        },
        onSubmit() {

            console.log(this.errors)
            if (this.errors.length === 0) {
                this.$store.commit('submitButtonLoadingStatus', true);
                this.axiosPost('covid/store-register-vaccine-user', {
                    fullName: this.fullName,
                    age: this.age,
                    email: this.email,
                    nid: this.nid,
                    phone: this.phone,
                    vaccineCenter: this.vaccineCenter,
                    selectedAppointmentDate: this.formattedDate,
                    alreadyBooked: this.alreadyBooked,
                    available: this.available,
                    alreadyRegisteredNid: this.alreadyRegisteredNid
                }, (response) => {
                    this.successNoti(response.message);
                    this.$store.commit('submitButtonLoadingStatus', false);
                    location.reload();
                }, (error) => {
                    this.errorNoti(error);
                    this.$store.commit('submitButtonLoadingStatus', false);
                })
            }

        }
    }
}
</script>
