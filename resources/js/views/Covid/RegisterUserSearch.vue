<template>
    <div class="content" id="registerUserSearch">
        <div class="container">
            <div class="row" style="padding-top:50px">
                <div class="col-md-12">
                    <ValidationObserver v-slot="{ handleSubmit }">
                        <div>
                            <form class="form-horizontal" style="padding-bottom: 30px"
                                  @submit.prevent="handleSubmit(searchNidHistory)">
                                <div class="col-md-8">
                                    <ValidationProvider name="NID" mode="eager"
                                                        rules="required|min:6"
                                                        v-slot="{ errors }">
                                        <div class="form-group row">
                                            <div class="col-md-2">
                                                <label for="chassisNo" class="col-lg-9 col-form-label">
                                                    NID <span class="error">*</span></label>
                                            </div>
                                            <div class="col-md-5">
                                                <div class="col-lg-12">
                                                    <input type="number" class="form-control"
                                                           id="nid"
                                                           data-nid="true"
                                                           v-model="nid" name="nid"
                                                           placeholder="NID Number">
                                                    <span class="error-message"> {{ errors[0] }}</span>
                                                </div>
                                            </div>

                                            <div class="col-md-2">
                                                <div class="col-lg-3">
                                                    <submit-form name="Search"/>
                                                </div>
                                            </div>
                                        </div>
                                    </ValidationProvider>
                                </div>

                            </form>
                        </div>
                    </ValidationObserver>
                </div>

            </div>

            <div id="serviceHistoryInfo" v-if="historyDataTag">
                <!-- User information -->
                <div class="row servInfo">
                    <div class="col-md-12">
                        <div class="x_panel table-responsive">
                            <div class="x_title" style="background: #d9edf7">
                                <span style="width: 65px; font-size: 20px; font-weight: bold; color:black;">User Information</span>
                                <div class="clearfix"></div>
                            </div>
                            <table class="table table-striped table-bordered small">
                                <thead>
                                <tr>
                                    <th>NID</th>
                                    <th class="text-center">Full Name</th>
                                    <th class="text-center">Age</th>
                                    <th class="text-center">Email</th>
                                    <th class="text-center">Phone</th>
                                    <th class="text-center">Appointment Status</th>
                                    <th class="text-center">Appointment Day</th>
                                    <th class="text-center">Vaccine Center</th>
                                    <th class="text-center">Apply Date</th>
                                </tr>
                                </thead>
                                <tbody id="custBody">
                                <td class="text-center">{{ userInfo.NID }}</td>
                                <td class="text-center">{{ userInfo.FullName }}</td>
                                <td class="text-center"> {{ userInfo.Age }}</td>
                                <td class="text-center">{{ userInfo.Email }}</td>
                                <td class="text-center">{{ userInfo.Phone }}</td>
                                <td class="text-center">
                                    <span v-if="isCurrentDateGreater"> Vaccinated</span>
                                    <span v-if="isCurrentDateSmaller"> Scheduled</span>
                                    <span v-if="comparisonDate===null"> Not Scheduled</span>
                                    <span v-if="areDatesEqual"> Today</span>
                                   </td>
                                <td class="text-center">{{ userInfo.AppointmentDay }}</td>
                                <td class="text-center">{{ userInfo.VaccineCenterName }}</td>
                                <td class="text-center">{{ userInfo.EntryDate }}</td>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import {Common} from '../../mixins/common'
import moment from "moment";
export default {
    mixins: [Common],
    data() {
        return {
            nid: '',
            historyDataTag:false,
            userInfo: {},
            comparisonDate: '', // Set your comparison date here


        }
    },
    computed: {
        currentDate() {
            return moment().format('YYYY-MM-DD'); // Current date in YYYY-MM-DD format
        },
        isCurrentDateGreater() {
            return moment(this.currentDate).isAfter(this.comparisonDate);
        },
        isCurrentDateSmaller() {
            return moment(this.currentDate).isBefore(this.comparisonDate);
        },
        areDatesEqual() {
            return moment(this.currentDate).isSame(this.comparisonDate);
        },
    },
    methods: {
        searchNidHistory() {
            let instance = this;
            if (instance.nid.length > 5) {
                instance.axiosGet('covid/check-nid-history/' + instance.nid, function (response) {
                  if(response.status==='success'){
                      instance.historyDataTag = true
                      instance.userInfo = response.results[0]
                    instance.comparisonDate =   response.results[0].AppointmentDay
                  }
                  else{
                      instance.errorNoti(response.message);
                      instance.$router.push({name: 'Registration'})
                  }

                }, function (error) {
                });
            }
        },
    }
}
</script>
