const result = document.getElementById("registrationResult");

// Check whether PHP sent a valid registration
const registrationElement = document.getElementById("registrationData");

if (registrationElement) {

    const registration = JSON.parse(registrationElement.textContent);

    // Save registration data in Local Storage
    localStorage.setItem("registration", JSON.stringify(registration));

    // Display the newly registered data
    displayRegistration(registration);

} else {

    // Do not display old data after an unsuccessful form submission
    const wasSubmitted = document.body.dataset.posted === "true";

    if (!wasSubmitted) {

        // Read previously saved registration data
        const savedData = localStorage.getItem("registration");

        if (savedData) {
            displayRegistration(JSON.parse(savedData));
        }
    }
}


// Function to display registration information
function displayRegistration(data) {

    result.replaceChildren();

    const title = document.createElement("h2");
    title.textContent = "Registration Successful!";
    result.appendChild(title);

    const fields = [
        ["Full Name", data.name],
        ["Email", data.email],
        ["Mobile", data.mobile],
        ["Governorate", data.governorate],
        ["Track", data.track],
        ["Skills", data.skills.join(", ")],
        ["Message", data.message || "No message"]
    ];

    fields.forEach(function (field) {

        const paragraph = document.createElement("p");

        paragraph.textContent = field[0] + ": " + field[1];

        result.appendChild(paragraph);
    });
}