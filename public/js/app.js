
// Vue App

const app = Vue.createApp({
    
    data() {
        return {
            // Errors

            displayErrors: false,

            errors: []
        }
    },

    methods: {

        // Submit The Form

        submitForm() {
            this.$refs["form"].submit();
        },

        // Check If Terms Are Accepted

        validateTerms() {
            checkboxChecked = document.querySelector("input[name=terms]").checked

            // If Not, Add An Error

            if (!checkboxChecked) {
                error = {
                    "name": "termsError",
                    "message": "You must accept the terms and conditions"
                }

                this.errors.push(error)
                return false
            }

            else {
                    return true
            }
        },

        // Check If Email Is Structured Correctly

        testEmail(email) {
            if (/^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/.test(email))
                {
                    return (true)
                }
            return false
        },

        // Email Validation

        validateEmail() {
            emailInput = checkboxChecked = document.querySelector("input[name=email]").value

            // Check If Input Field Is Not Empty

            if (emailInput === "") {

                error = {
                    "name": "emailError",
                    "message": "Email address is required"
                }

                this.errors.push(error)
            }

            // Check If Email Has Valid Structure

            else if (!this.testEmail(emailInput)) {
                error = {
                    "name": "emailError",
                    "message": "Please provide a valid e-mail address"
                }
                this.errors.push(error)
            }

            // Check If Email Ends With ".co"

            else if (emailInput.endsWith(".co")) {
                error = {
                    "name": "emailError",
                    "message": "We are not accepting subscriptions from Colombia emails"
                }
                this.errors.push(error)
            }

            else {
                return true
            }
            return false
        },

        // Validate Input

        validate() {
            this.errors = []
            validTerms = this.validateTerms()
            validEmail = this.validateEmail()

            // If Both Fields Are Valid, Confirm Successful Validation And Submit Form

            if (validEmail && validTerms) {
                this.submitForm();
            }

            // Else Display Errors
            
            else {
                this.displayErrors = true
            }
        },
    },
})
app.mount('#app')