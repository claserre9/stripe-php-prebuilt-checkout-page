import ko from 'knockout';

// Define the ViewModel
function DonationViewModel() {
    console.log('DonationViewModel loaded');
    const self = this;

    // Observable for the donation amount
    self.amount = ko.observable('');

    // Predefined donation amounts
    self.presetAmounts = [10, 25, 50];

    // Set the amount when a preset button is clicked
    self.selectPresetAmount = function (amount) {
        self.amount(amount); // Update the observable
    };

    // On form submit
    self.submitDonation = function (formElement) {
        // Ensure the form is submitted with the latest amount value
        if (self.amount() <= 0) {
            alert('Please enter a valid donation amount.');
            return false;
        }

        // Continue with form submission
        formElement.submit();
    };
}

// Apply Knockout bindings when the page loads
document.addEventListener('DOMContentLoaded', () => {
    ko.applyBindings(new DonationViewModel());
});