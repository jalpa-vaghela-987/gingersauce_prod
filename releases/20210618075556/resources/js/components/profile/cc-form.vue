<template>
    <div class="cc-card-form-wrapper">
        <h2 class="mb-2">
            {{ translate( 'Billing information' ) }}
        </h2>
        <div class="bg-white rounded p-4">
            <div class="form-group">
                <label for="invoice-co-name">
                    {{ translate( 'Name on invoice' ) }}
                </label>
                <input name="name" id="invoice-co-name" type="text" class="form-control underlined" v-model="name">
            </div>
            <div class="form-group">
                <label for="invoice-co-country">
                    {{ translate( 'Country' ) }}
                </label>
                <select type="text" class="form-control underlined" name="country" id="invoice-co-country"
                        v-model="country">
                    <option value="AF">Afghanistan</option>
                    <option value="AX">land Islands</option>
                    <option value="AL">Albania</option>
                    <option value="DZ">Algeria</option>
                    <option value="AS">American Samoa</option>
                    <option value="AD">AndorrA</option>
                    <option value="AO">Angola</option>
                    <option value="AI">Anguilla</option>
                    <option value="AQ">Antarctica</option>
                    <option value="AG">Antigua and Barbuda</option>
                    <option value="AR">Argentina</option>
                    <option value="AM">Armenia</option>
                    <option value="AW">Aruba</option>
                    <option value="AU">Australia</option>
                    <option value="AT">Austria</option>
                    <option value="AZ">Azerbaijan</option>
                    <option value="BS">Bahamas</option>
                    <option value="BH">Bahrain</option>
                    <option value="BD">Bangladesh</option>
                    <option value="BB">Barbados</option>
                    <option value="BY">Belarus</option>
                    <option value="BE">Belgium</option>
                    <option value="BZ">Belize</option>
                    <option value="BJ">Benin</option>
                    <option value="BM">Bermuda</option>
                    <option value="BT">Bhutan</option>
                    <option value="BO">Bolivia</option>
                    <option value="BA">Bosnia and Herzegovina</option>
                    <option value="BW">Botswana</option>
                    <option value="BV">Bouvet Island</option>
                    <option value="BR">Brazil</option>
                    <option value="IO">British Indian Ocean Territory</option>
                    <option value="BN">Brunei Darussalam</option>
                    <option value="BG">Bulgaria</option>
                    <option value="BF">Burkina Faso</option>
                    <option value="BI">Burundi</option>
                    <option value="KH">Cambodia</option>
                    <option value="CM">Cameroon</option>
                    <option value="CA">Canada</option>
                    <option value="CV">Cape Verde</option>
                    <option value="KY">Cayman Islands</option>
                    <option value="CF">Central African Republic</option>
                    <option value="TD">Chad</option>
                    <option value="CL">Chile</option>
                    <option value="CN">China</option>
                    <option value="CX">Christmas Island</option>
                    <option value="CC">Cocos (Keeling) Islands</option>
                    <option value="CO">Colombia</option>
                    <option value="KM">Comoros</option>
                    <option value="CG">Congo</option>
                    <option value="CD">Congo, The Democratic Republic of the</option>
                    <option value="CK">Cook Islands</option>
                    <option value="CR">Costa Rica</option>
                    <option value="CI">Cote D"Ivoire</option>
                    <option value="HR">Croatia</option>
                    <option value="CU">Cuba</option>
                    <option value="CY">Cyprus</option>
                    <option value="CZ">Czech Republic</option>
                    <option value="DK">Denmark</option>
                    <option value="DJ">Djibouti</option>
                    <option value="DM">Dominica</option>
                    <option value="DO">Dominican Republic</option>
                    <option value="EC">Ecuador</option>
                    <option value="EG">Egypt</option>
                    <option value="SV">El Salvador</option>
                    <option value="GQ">Equatorial Guinea</option>
                    <option value="ER">Eritrea</option>
                    <option value="EE">Estonia</option>
                    <option value="ET">Ethiopia</option>
                    <option value="FK">Falkland Islands (Malvinas</option>
                    <option value="FO">Faroe Islands</option>
                    <option value="FJ">Fiji</option>
                    <option value="FI">Finland</option>
                    <option value="FR">France</option>
                    <option value="GF">French Guiana</option>
                    <option value="PF">French Polynesia</option>
                    <option value="TF">French Southern Territories</option>
                    <option value="GA">Gabon</option>
                    <option value="GM">Gambia</option>
                    <option value="GE">Georgia</option>
                    <option value="DE">Germany</option>
                    <option value="GH">Ghana</option>
                    <option value="GI">Gibraltar</option>
                    <option value="GR">Greece</option>
                    <option value="GL">Greenland</option>
                    <option value="GD">Grenada</option>
                    <option value="GP">Guadeloupe</option>
                    <option value="GU">Guam</option>
                    <option value="GT">Guatemala</option>
                    <option value="GG">Guernsey</option>
                    <option value="GN">Guinea</option>
                    <option value="GW">Guinea-Bissau</option>
                    <option value="GY">Guyana</option>
                    <option value="HT">Haiti</option>
                    <option value="HM">Heard Island and Mcdonald Islands</option>
                    <option value="VA">Holy See (Vatican City State</option>
                    <option value="HN">Honduras</option>
                    <option value="HK">Hong Kong</option>
                    <option value="HU">Hungary</option>
                    <option value="IS">Iceland</option>
                    <option value="IN">India</option>
                    <option value="ID">Indonesia</option>
                    <option value="IR">Iran, Islamic Republic Of</option>
                    <option value="IQ">Iraq</option>
                    <option value="IE">Ireland</option>
                    <option value="IM">Isle of Man</option>
                    <option value="IL">Israel</option>
                    <option value="IT">Italy</option>
                    <option value="JM">Jamaica</option>
                    <option value="JP">Japan</option>
                    <option value="JE">Jersey</option>
                    <option value="JO">Jordan</option>
                    <option value="KZ">Kazakhstan</option>
                    <option value="KE">Kenya</option>
                    <option value="KI">Kiribati</option>
                    <option value="KP">Korea, Democratic People"S Republic of</option>
                    <option value="KR">Korea, Republic of</option>
                    <option value="KW">Kuwait</option>
                    <option value="KG">Kyrgyzstan</option>
                    <option value="LA">Lao People"S Democratic Republic</option>
                    <option value="LV">Latvia</option>
                    <option value="LB">Lebanon</option>
                    <option value="LS">Lesotho</option>
                    <option value="LR">Liberia</option>
                    <option value="LY">Libyan Arab Jamahiriya</option>
                    <option value="LI">Liechtenstein</option>
                    <option value="LT">Lithuania</option>
                    <option value="LU">Luxembourg</option>
                    <option value="MO">Macao</option>
                    <option value="MK">Macedonia, The Former Yugoslav Republic of</option>
                    <option value="MG">Madagascar</option>
                    <option value="MW">Malawi</option>
                    <option value="MY">Malaysia</option>
                    <option value="MV">Maldives</option>
                    <option value="ML">Mali</option>
                    <option value="MT">Malta</option>
                    <option value="MH">Marshall Islands</option>
                    <option value="MQ">Martinique</option>
                    <option value="MR">Mauritania</option>
                    <option value="MU">Mauritius</option>
                    <option value="YT">Mayotte</option>
                    <option value="MX">Mexico</option>
                    <option value="FM">Micronesia, Federated States of</option>
                    <option value="MD">Moldova, Republic of</option>
                    <option value="MC">Monaco</option>
                    <option value="MN">Mongolia</option>
                    <option value="M">Montenegro</option>
                    <option value="M">Montserrat</option>
                    <option value="MA">Morocco</option>
                    <option value="MZ">Mozambique</option>
                    <option value="MM">Myanmar</option>
                    <option value="NA">Namibia</option>
                    <option value="NR">Nauru</option>
                    <option value="NP">Nepal</option>
                    <option value="NL">Netherlands</option>
                    <option value="AN">Netherlands Antilles</option>
                    <option value="NC">New Caledonia</option>
                    <option value="NZ">New Zealand</option>
                    <option value="NI">Nicaragua</option>
                    <option value="NE">Niger</option>
                    <option value="NG">Nigeria</option>
                    <option value="NU">Niue</option>
                    <option value="NF">Norfolk Island</option>
                    <option value="MP">Northern Mariana Islands</option>
                    <option value="NO">Norway</option>
                    <option value="OM">Oman</option>
                    <option value="PK">Pakistan</option>
                    <option value="PW">Palau</option>
                    <option value="PS">Palestinian Territory, Occupied</option>
                    <option value="PA">Panama</option>
                    <option value="PG">Papua New Guinea</option>
                    <option value="PY">Paraguay</option>
                    <option value="PE">Peru</option>
                    <option value="PH">Philippines</option>
                    <option value="PN">Pitcairn</option>
                    <option value="PL">Poland</option>
                    <option value="PT">Portugal</option>
                    <option value="PR">Puerto Rico</option>
                    <option value="QA">Qatar</option>
                    <option value="RE">Reunion</option>
                    <option value="RO">Romania</option>
                    <option value="RU">Russian Federation</option>
                    <option value="RW">RWANDA</option>
                    <option value="SH">Saint Helena</option>
                    <option value="KN">Saint Kitts and Nevis</option>
                    <option value="LC">Saint Lucia</option>
                    <option value="PM">Saint Pierre and Miquelon</option>
                    <option value="VC">Saint Vincent and the Grenadines</option>
                    <option value="WS">Samoa</option>
                    <option value="SM">San Marino</option>
                    <option value="ST">Sao Tome and Principe</option>
                    <option value="SA">Saudi Arabia</option>
                    <option value="SN">Senegal</option>
                    <option value="RS">Serbia</option>
                    <option value="SC">Seychelles</option>
                    <option value="SL">Sierra Leone</option>
                    <option value="SG">Singapore</option>
                    <option value="SK">Slovakia</option>
                    <option value="SI">Slovenia</option>
                    <option value="SB">Solomon Islands</option>
                    <option value="SO">Somalia</option>
                    <option value="ZA">South Africa</option>
                    <option value="GS">South Georgia and the South Sandwich Islands</option>
                    <option value="ES">Spain</option>
                    <option value="LK">Sri Lanka</option>
                    <option value="SD">Sudan</option>
                    <option value="SR">Suriname</option>
                    <option value="SJ">Svalbard and Jan Mayen</option>
                    <option value="SZ">Swaziland</option>
                    <option value="SE">Sweden</option>
                    <option value="CH">Switzerland</option>
                    <option value="SY">Syrian Arab Republic</option>
                    <option value="TW">Taiwan, Province of China</option>
                    <option value="TJ">Tajikistan</option>
                    <option value="TZ">Tanzania, United Republic of</option>
                    <option value="TH">Thailand</option>
                    <option value="TL">Timor-Leste</option>
                    <option value="TG">Togo</option>
                    <option value="TK">Tokelau</option>
                    <option value="TO">Tonga</option>
                    <option value="TT">Trinidad and Tobago</option>
                    <option value="TN">Tunisia</option>
                    <option value="TR">Turkey</option>
                    <option value="TM">Turkmenistan</option>
                    <option value="TC">Turks and Caicos Islands</option>
                    <option value="TV">Tuvalu</option>
                    <option value="UG">Uganda</option>
                    <option value="UA">Ukraine</option>
                    <option value="AE">United Arab Emirates</option>
                    <option value="GB">United Kingdom</option>
                    <option value="US">United States</option>
                    <option value="UM">United States Minor Outlying Islands</option>
                    <option value="UY">Uruguay</option>
                    <option value="UZ">Uzbekistan</option>
                    <option value="VU">Vanuatu</option>
                    <option value="VE">Venezuela</option>
                    <option value="VN">Viet Nam</option>
                    <option value="VG">Virgin Islands, British</option>
                    <option value="VI">Virgin Islands, U.S</option>
                    <option value="WF">Wallis and Futuna</option>
                    <option value="EH">Western Sahara</option>
                    <option value="YE">Yemen</option>
                    <option value="ZM">Zambia</option>
                    <option value="ZW">Zimbabwe</option>
                </select>
            </div>
            <div class="form-group required">
                <label for="invoice-co-address1">
                    {{ translate( 'Address line 1' ) }}
                </label>
                <input name="address1" required id="invoice-co-address1" type="text" class="form-control underlined"
                       v-model="address1">
            </div>
            <div class="form-group">
                <label for="invoice-co-address2">
                    {{ translate( 'Address line 2' ) }}
                </label>
                <input name="address2" id="invoice-co-address2" type="text" class="form-control underlined"
                       v-model="address2">
            </div>
            <div class="form-group required">
                <label for="invoice-co-city">
                    {{ translate( 'City' ) }}
                </label>
                <input name="city" required id="invoice-co-city" type="text" class="form-control underlined"
                       v-model="city">
            </div>
            <div class="form-group">
                <label for="invoice-co-state">
                    {{ translate( 'State/Province/Region' ) }}
                </label>
                <input name="state" id="invoice-co-state" type="text" class="form-control underlined" v-model="state">
            </div>
            <div class="form-group required">
                <label for="invoice-co-zip">
                    {{ translate( 'Zip/Postal code' ) }}
                </label>
                <input name="zip" required id="invoice-co-zip" type="text" class="form-control underlined"
                       v-model="zip">
            </div>
        </div>

        <input type="hidden" name="custom_client_id" v-model="user_id">
        <div class="cc-form" v-if="cc_form">
            <h2 class="mt-4 mb-2">
                {{ translate( 'Payment method' ) }}
            </h2>
            <div class="bg-white rounded p-4 mb-5">
                <div class="form-group required">
                    <label for="invoice-co-name-on-card">
                        {{ translate( 'Name on card' ) }}
                    </label>
                    <input name="name_on_card" required id="invoice-co-name-on-card" type="text"
                           class="form-control underlined" v-model="name_on_card">
                </div>
                <div class="form-group required" v-if="country == 'IL'">
                    <label for="invoice-co-id-on-card">
                        {{ translate( 'Card holder ID' ) }}
                    </label>
                    <input name="id_on_card" required id="invoice-co-id-on-card" type="text"
                           class="form-control underlined"
                           v-model="id_on_card">
                </div>
                <div class="form-group required position-relative">
                    <label for="invoice-co-cc">{{ translate( 'Credit card number' ) }}</label>
                    <input name="cc" id="invoice-co-cc" required type="text" class="form-control underlined"
                           v-model="cc"
                           placeholder="0012 3456 7890 1234">
                    <div class="img-description">
                        <img :src="cards" alt="CVC">
                    </div>
                </div>
                <div class="row">
                    <div class="col-3">
                        <div class="form-group required">
                            <label for="invoice-co-exp-year">{{ translate( 'Expiration Year' ) }}</label>
                            <select type="text" class="form-control underlined" name="exp_year" id="invoice-co-exp-year"
                                    v-model="selected_year" required>
                                <option v-for="year in years" :value="year">{{ year }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group required">
                            <label for="invoice-co-exp-month">{{ translate( 'Expiration month' ) }}</label>
                            <select type="text" class="form-control underlined" name="exp_month"
                                    id="invoice-co-exp-month"
                                    v-model="selected_month" required>
                                <option v-for="month in months" :value="month">{{ month }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group required position-relative">
                            <label for="invoice-co-cvc">{{ translate( 'CVC' ) }}</label>
                            <input name="cvc" required id="invoice-co-cvc" maxlength="4" type="password"
                                   class="form-control underlined" v-model="cvc" placeholder="123">
                            <div class="img-description">
                                <img :src="cvc_img" alt="CVC">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="button-wrapper">
            <div class="row">
                <button class="profile-button save-cc-data" @click="proceed" :disabled="!load">{{
                        translate( 'Save' )
                    }}
                </button>
                <a :href="cancel_href" class="profile-href bg-transparent">{{ translate( 'Cancel' ) }}</a>
            </div>
        </div>
    </div>
</template>
<script>
import translate from '../../utils/translate';

export default {
    props: {
        user_id    : Number,
        cvc_img    : String,
        cards      : String,
        action     : String,
        cc_form    : false,
        cancel_href: String,
    },
    data() {
        return {
            name          : '',
            country       : '',
            address1      : '',
            address2      : '',
            city          : '',
            state         : '',
            zip           : '',
            name_on_card  : '',
            id_on_card    : '',
            cc            : '',
            exp           : '',
            cvc           : '',
            total         : Number,
            endpoints     : endpoints,
            loading       : true,
            selected_year : Number,
            selected_month: Number,
            months        : [ 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12 ],
        };
    },
    computed: {
        years() {
            var yearStart = new Date().getUTCFullYear();
            let years = [];
            for ( let i = yearStart; i < ( yearStart + 20 ); i++ ) {
                years.push( i );
            }
            return years;
        },
    },
    mounted() {
        this.boot();
        this.load();
    },
    methods: {
        translate,
        load() {
            axios.post( endpoints.ajax.post.load_user, { id: this.id, user_id: this.user_id } ).then( response => {
                if ( response.data.status == 'ok' ) {
                    this.name = response.data.name;
                    this.country = response.data.country;
                    this.address1 = response.data.address1;
                    this.address2 = response.data.address2;
                    this.city = response.data.city;
                    this.state = response.data.state;
                    this.zip = response.data.zip;
                    this.loading = false;
                }
            } );
        },
        boot() {
            axios.get( 'http://ip-api.com/json' ).then( response => {
                this.country = response.data.countryCode;
            } );

            if ( this.cc_form ) {
                var cleaveCreditCard = new Cleave( '#invoice-co-cc', {
                    creditCard: true,
                } );
            }
        },
        update() {
            this.loading = true;
            axios.post( this.endpoints.ajax.post.update_billing_info, {
                name    : this.name,
                country : this.country,
                address1: this.address1,
                address2: this.address2,
                city    : this.city,
                state   : this.state,
                zip     : this.zip,
            } ).then( response => {
                this.loading = false;
                window.location = this.cancel_href;
            } );
        },
        create() {
            this.loading = true;
            axios.post( this.endpoints.ajax.post.cc_card_save, {
                name        : this.name,
                country     : this.country,
                address1    : this.address1,
                address2    : this.address2,
                city        : this.city,
                state       : this.state,
                zip         : this.zip,
                name_on_card: this.name_on_card,
                cc          : this.cc,
                exp_year    : this.selected_year,
                exp_month   : this.selected_month,
                cvc         : this.cvc,
            } ).then( response => {
                // this.loading = false;
                // window.location = this.cancel_href;
            } ).catch( error => {
                this.loading = false;
                new Noty( {
                              type   : 'error',
                              text   : error.response.data.msg,
                              timeout: 5000,
                          } ).show();
            } );
        },
        proceed() {
            if ( this.cc_form ) {
                this.create();
            } else {
                this.update();
            }
        },
    },
};
</script>
<style lang="scss">
.required {
    label {
        &:after {
            content: " *";
            color: #EE6636;
        }
    }
}
</style>
