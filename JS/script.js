document.addEventListener("DOMContentLoaded", function () {
    const passwordInput = document.getElementById("password");
    const togglePassword = document.getElementById("togglePassword");

    const confirmPasswordInput = document.getElementById("confirmPassword");
    const toggleConfirmPassword = document.getElementById("toggleConfirmPassword");

   
    if (passwordInput && togglePassword) {
        togglePassword.addEventListener("click", function () {
            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                togglePassword.classList.remove("fa-eye");
                togglePassword.classList.add("fa-eye-slash");
            } else {
                passwordInput.type = "password";
                togglePassword.classList.remove("fa-eye-slash");
                togglePassword.classList.add("fa-eye");
            }
        });
    }

    if (confirmPasswordInput && toggleConfirmPassword) {
        toggleConfirmPassword.addEventListener("click", function () {
            if (confirmPasswordInput.type === "password") {
                confirmPasswordInput.type = "text";
                toggleConfirmPassword.classList.remove("fa-eye");
                toggleConfirmPassword.classList.add("fa-eye-slash");
            } else {
                confirmPasswordInput.type = "password";
                toggleConfirmPassword.classList.remove("fa-eye-slash");
                toggleConfirmPassword.classList.add("fa-eye");
            }
        });
    }
});


document.addEventListener("DOMContentLoaded", function () {
    const errorMessage = document.getElementById("login-error");

    if (errorMessage) {
        setTimeout(() => {
            errorMessage.classList.add("hidden");
            setTimeout(() => {
                errorMessage.remove();
            }, 1000);
        }, 5000);
    }
});

document.addEventListener("DOMContentLoaded", function() {
    const successMsg = document.getElementById('delete-success');
    const errorMsg = document.getElementById('delete-error');

    console.log("Success message element:", successMsg); 
    console.log("Error message element:", errorMsg); 

    if (successMsg) {
        console.log("Hiding success message...");
        setTimeout(() => {
            successMsg.style.transition = "opacity 1s ease";
            successMsg.style.opacity = 0;
            setTimeout(() => {
                successMsg.remove(); 
            }, 1000); 
        }, 3000); 
    }

    if (errorMsg) {
        console.log("Hiding error message...");
        setTimeout(() => {
            errorMsg.style.transition = "opacity 1s ease";
            errorMsg.style.opacity = 0;
            setTimeout(() => {
                errorMsg.remove(); 
            }, 1000);
        }, 3000);
    }
});

// Inline editing for modules
function saveModule(moduleId) {
    const moduleNameInput = document.getElementById(`module-name-${moduleId}`);
    const moduleName = moduleNameInput.value;

    if (moduleName.trim() === '') {
        alert('Module name cannot be empty.');
        return;
    }

    fetch('/coursework/Admin/edit_module.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `module_id=${moduleId}&module_name=${encodeURIComponent(moduleName)}`
    })
    .then(response => response.text())
    .then(data => {
        if (data.trim() === 'success') {
            alert('Module updated successfully.');
        } else {
            alert('Error updating module: ' + data);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while updating the module.');
    });
};


function initializeContactForm() {
    const contactForm = document.getElementById("contact-form");
    const responseMessage = document.getElementById("response-message");

    console.log("Contact form:", contactForm); // Debugging: Check if the form exists
    console.log("Response message container:", responseMessage); // Debugging: Check if the response container exists

    if (contactForm) {
        contactForm.addEventListener("submit", async function (e) {
            e.preventDefault(); // Prevent default form submission

            const formData = new FormData(this);

            try {
                const response = await fetch(contactForm.action, {
                    method: 'POST',
                    body: formData,
                });

                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }

                const contentType = response.headers.get("content-type");
                if (contentType && contentType.includes("application/json")) {
                    const result = await response.json();

                    if (result.success) {
                        // Display success message
                        responseMessage.innerHTML = `<p style="color: green;">${result.message}</p>`;
                        contactForm.reset(); // Clear the form fields
                    } else {
                        // Display error message
                        responseMessage.innerHTML = `<p style="color: red;">${result.message}</p>`;
                    }
                } else {
                    const text = await response.text();
                    console.error("Unexpected response:", text);
                    responseMessage.innerHTML = `<p style="color: red;">Unexpected response from the server.</p>`;
                }
            } catch (error) {
                console.error("Error during form submission:", error);
                responseMessage.innerHTML = `<p style="color: red;">An error occurred. Please try again later.</p>`;
            }
        });
    }

    // Display the message from session storage if available
    const storedMessage = sessionStorage.getItem('response_message');
    if (storedMessage) {
        responseMessage.innerHTML = storedMessage;
        sessionStorage.removeItem('response_message'); // Clear the message after displaying it
    }
}

// Event listener for dynamically loading the contact form
document.addEventListener("DOMContentLoaded", function () {
    const contactTab = document.getElementById("contact-tab");
    const mainContent = document.querySelector("main");

    if (contactTab) {
        contactTab.addEventListener("click", function (e) {
            e.preventDefault(); // Prevent default navigation

            // Update the browser's URL to reflect the contact page
            history.pushState(null, "", "/coursework/templates/contact_admin.html.php");

            // Fetch the contact form dynamically
            fetch("/coursework/templates/contact_admin.html.php")
                .then((response) => {
                    if (!response.ok) {
                        throw new Error("Failed to load contact form.");
                    }
                    return response.text(); // Get the HTML content
                })
                .then((html) => {
                    mainContent.innerHTML = html; // Replace main content with the form
                    initializeContactForm(); // Reinitialize the form logic after loading
                })
                .catch((error) => {
                    console.error("Error:", error);
                });
        });
    }

    // Handle browser back/forward navigation
    window.addEventListener("popstate", function () {
        const currentPath = window.location.pathname;

        if (currentPath === "/coursework/templates/contact_admin.html.php") {
            // Reload the contact form if the user navigates back to the contact page
            fetch("/coursework/templates/contact_admin.html.php")
                .then((response) => response.text())
                .then((html) => {
                    mainContent.innerHTML = html;
                    initializeContactForm();
                })
                .catch((error) => console.error("Error:", error));
        } else {
            // Handle other paths or reload the default content
            window.location.reload();
        }
    });
});

document.addEventListener("DOMContentLoaded", function () {
    const tabLinks = document.querySelectorAll(".tab-link");
    const tabContents = document.querySelectorAll(".tab-content");

    // Get the fragment identifier from the URL
    const hash = window.location.hash.substring(1); // Remove the '#' symbol
    const defaultTab = hash || "manageUsers";

    // Activate the default tab
    const defaultTabLink = document.querySelector(`.tab-link[data-tab="${defaultTab}"]`);
    const defaultTabContent = document.getElementById(defaultTab);

    if (defaultTabLink && defaultTabContent) {
        defaultTabLink.classList.add("active-tab");
        defaultTabContent.classList.add("active-tab");
    }

    // Add click event listeners for tab links
    tabLinks.forEach(link => {
        link.addEventListener("click", function (e) {
            e.preventDefault();

            // Remove active class from all tabs and hide all content
            tabLinks.forEach(link => link.classList.remove("active-tab"));
            tabContents.forEach(content => content.classList.remove("active-tab"));

            // Add active class to the clicked tab and show the corresponding content
            const targetTab = this.getAttribute("data-tab");
            const targetElement = document.getElementById(targetTab);

            if (targetElement) {
                targetElement.classList.add("active-tab");
                this.classList.add("active-tab");
            } else {
                console.error(`Element with id "${targetTab}" not found.`);
            }
        });
    });
});

document.addEventListener("DOMContentLoaded", function () {
    const navLinks = document.querySelectorAll("nav a");

    // Add click event listener to each navigation link
    navLinks.forEach(link => {
        link.addEventListener("click", function () {
            // Remove the "active-tab" class from all links
            navLinks.forEach(nav => nav.classList.remove("active-tab"));

            // Add the "active-tab" class to the clicked link
            this.classList.add("active-tab");
        });
    });

    // Highlight the active tab based on the current URL
    const currentPath = window.location.pathname;
    navLinks.forEach(link => {
        if (link.getAttribute("href") === currentPath) {
            link.classList.add("active-tab");
        }
    });
});


