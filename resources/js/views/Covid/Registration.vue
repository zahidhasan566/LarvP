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

                <ValidationProvider name="selectedAppointmentDate" mode="eager" rules="required" v-slot="{ errors }">
                    <div class="form-group">
                        <label for="Appointment">Appointment Day</label>

                        <vuejs-datepicker
                            v-model="selectedAppointmentDate"
                            :disabled-dates="disabledDates"
                            :highlighted="highlightedDays"
                            :bootstrap-styling="true"
                        />
                        <span class="error-message">{{ errors[0] }}</span>
                    </div>
                </ValidationProvider>
                <ValidationProvider name="Vaccine Center" mode="eager" rules="required" v-slot="{ errors }">
                    <div class="form-group">
                        <label for="VaccineCenter">Vaccine Center</label>
                        <multiselect v-model="vaccineCenter"
                                     :options="vaccineCenters"
                                     @input="checkVaccineLimit($event)"
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
                                   v-model="alreadyBooked" name="alreadyBooked" >
                        </div>

                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="fullName">Available</label>
                            <input type="number" readonly class="form-control"  id="available"
                                   v-model="available" name="available" >
                        </div>

                    </div>
                </div>

                <ValidationProvider name="Full Name" mode="eager" rules="required" v-slot="{ errors }">
                <div class="form-group">
                    <label for="fullName">Full Name</label>
                    <input type="text" class="form-control" :class="{'error-border': errors[0]}" id="fullName"
                           v-model="fullName" name="fullName" placeholder="Full Name" autocomplete="off">
                  <span class="error-message"> {{ errors[0] }}</span>
                </div>
              </ValidationProvider>


                <div class="row">
                    <div class="col-md-4">
                        <ValidationProvider name="Age" mode="eager" rules="required" v-slot="{ errors }">
                            <div class="form-group">
                                <label for="user-password">Age</label>
                                <input type="number" min="10" v-model="age" class="form-control" :class="{'error-border': errors[0]}"
                                       id="age" placeholder="Age" autocomplete>
                                <span class="error-message">{{ errors[0] }}</span>
                            </div>
                        </ValidationProvider>
                    </div>

                    <div class="col-md-8">
                        <ValidationProvider name="Email" mode="eager" rules="required" v-slot="{ errors }">
                            <div class="form-group">
                                <label for="user-password">Email</label>
                                <input type="email" v-model="email" class="form-control" :class="{'error-border': errors[0]}"
                                       id="email" placeholder="Email" autocomplete>
                                <span class="error-message">{{ errors[0] }}</span>
                            </div>
                        </ValidationProvider>
                    </div>


                </div>
                <div class="row">
                    <div class="col-md-6">
                        <ValidationProvider name="NID" mode="eager" rules="required" v-slot="{ errors }">
                            <div class="form-group">
                                <label for="nid">NID</label>
                                <input type="number"  v-model="nid" class="form-control" :class="{'error-border': errors[0]}"
                                       id="nid" placeholder="NID" autocomplete>
                                <span class="error-message">{{ errors[0] }}</span>
                            </div>
                        </ValidationProvider>
                    </div>

                    <div class="col-md-6">
                        <ValidationProvider name="Phone" mode="eager" rules="required" v-slot="{ errors }">
                            <div class="form-group">
                                <label for="Phone">Phone</label>
                                <input type="tel" pattern='(01)?[0-9]{11}'
                                       v-model="phone" class="form-control" :class="{'error-border': errors[0]}"
                                       id="phone" placeholder="Phone" autocomplete>
                                <span class="error-message">{{ errors[0] }}</span>
                            </div>
                        </ValidationProvider>
                    </div>
                </div>


              <submit-form name="Log In"/>
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
                return day === 0 || day === 1 || day === 2 || day === 3 || day === 4 ;
            }
        },
        fullName:'',
        age:'',
        email:'',
        nid:'',
        phone:'',
        vaccineCenters:[],
        vaccineCenter:'',
        selectedAppointmentDate: '',
        alreadyBooked:0,
        available:0,



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
      getSupportingData(){
          let instance = this;
          this.axiosGet('covid/registration-supporting-data', function (response) {
              instance.vaccineCenters = response.vaccineCenters;
              console.log(instance.vaccineCenters)
          }, function (error) {

          });

      },
      checkVaccineLimit(val){
          let instance = this;
          // this.axiosGet('covid/vaccine-center-capacity'+'/'+ val.VaccineCenterCode, function (response) {
          //     instance.vaccineCenters = response.vaccineCenters;
          //     console.log(instance.vaccineCenters)
          // }, function (error) {
          //
          // });

          console.log(this.formattedDate)
      },
      // checkSelectedDay() {
      //     if (this.selectedDate) {
      //         const day = this.selectedDate.getDay();
      //         this.selectedDay = day === 1 ? 'Monday' : 'Tuesday';
      //     } else {
      //         this.selectedDay = '';
      //     }
      // },
      checkSelectedDay(date) {
          console.log('Selected date:', date);
      },
    onSubmit() {
      this.$store.commit('submitButtonLoadingStatus', true);
      // this.axiosPostWithoutToken('login', {
      //   usermailorphone: this.usermailorphone,
      //   password: this.password
      // }, (response) => {
      //     console.log(response)
      //   localStorage.setItem("token", response.access_token);
      //   this.successNoti('Successfully logged in.');
      //   this.$store.commit('submitButtonLoadingStatus', false);
      //   this.redirect(this.mainOrigin + 'dashboard')
      // }, (error) => {
      //   this.errorNoti(error);
      //   this.$store.commit('submitButtonLoadingStatus', false);
      // })
    }
  }
}
</script>
