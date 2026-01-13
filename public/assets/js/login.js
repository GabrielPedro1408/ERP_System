// Initialize ScrollReveal
document.addEventListener("DOMContentLoaded", () => {
  const ScrollReveal = window.ScrollReveal
  const sr = ScrollReveal({
    origin: "bottom",
    distance: "30px",
    duration: 800,
    delay: 100,
    easing: "ease-in-out",
    reset: false,
  })

  // Reveal login container
  sr.reveal(".login-container", { delay: 200 })
})

// Toggle password visibility
function togglePassword() {
  const passwordInput = document.getElementById("password")
  const toggleIcon = document.getElementById("toggleIcon")

  if (passwordInput.type === "password") {
    passwordInput.type = "text"
    toggleIcon.classList.remove("fa-eye")
    toggleIcon.classList.add("fa-eye-slash")
  } else {
    passwordInput.type = "password"
    toggleIcon.classList.remove("fa-eye-slash")
    toggleIcon.classList.add("fa-eye")
  }
}

// Show loading overlay
function showLoading() {
  document.getElementById("loadingOverlay").style.display = "flex"
}

// Hide loading overlay
function hideLoading() {
  document.getElementById("loadingOverlay").style.display = "none"
}

// Form validation
function validateForm(form) {
  const inputs = form.querySelectorAll("input[required]")
  let isValid = true

  inputs.forEach((input) => {
    if (!input.value.trim()) {
      input.style.borderColor = "#ff6b6b"
      isValid = false
    } else {
      input.style.borderColor = "rgba(255, 228, 77, 0.3)"
    }
  })

  return isValid
}

// Handle form submissions
document.addEventListener("DOMContentLoaded", () => {
  const loginForm = document.querySelector(".login-form")

  // Login form submission
  if (loginForm) {
    loginForm.addEventListener("submit", (e) => {

      if (validateForm(loginForm)) {
        showLoading()

        // Simulate API call
        setTimeout(() => {
          hideLoading()
          // Here you would normally submit to your backend
          console.log("Login form submitted")
        }, 2000)
      }
    })
  }
})

// Input focus effects
document.addEventListener("DOMContentLoaded", () => {
  const inputs = document.querySelectorAll(".input-field input")

  inputs.forEach((input) => {
    input.addEventListener("focus", () => {
      input.parentElement.style.transform = "scale(1.02)"
    })

    input.addEventListener("blur", () => {
      input.parentElement.style.transform = "scale(1)"
    })
  })
})

// Check for error parameter in URL
document.addEventListener("DOMContentLoaded", () => {
  const urlParams = new URLSearchParams(window.location.search)
  const error = urlParams.get("error")

  if (error === "incorrect") {
    const errorMessage = document.getElementById("errorMessage")
    if (errorMessage) {
      errorMessage.style.display = "flex"
      setTimeout(() => {
        errorMessage.style.display = "none"
      }, 5000)
    }
  }
})

// Add ripple effect to buttons
document.addEventListener("DOMContentLoaded", () => {
  const buttons = document.querySelectorAll(".btn-login, .btn-social, .btn-toggle")

  buttons.forEach((button) => {
    button.addEventListener("click", function (e) {
      const ripple = document.createElement("span")
      const rect = this.getBoundingClientRect()
      const size = Math.max(rect.width, rect.height)
      const x = e.clientX - rect.left - size / 2
      const y = e.clientY - rect.top - size / 2

      ripple.style.width = ripple.style.height = size + "px"
      ripple.style.left = x + "px"
      ripple.style.top = y + "px"
      ripple.classList.add("ripple")

      this.appendChild(ripple)

      setTimeout(() => {
        ripple.remove()
      }, 600)
    })
  })
})

// Add CSS for ripple effect
const style = document.createElement("style")
style.textContent = `
    .btn-login, .btn-social, .btn-toggle {
        position: relative;
        overflow: hidden;
    }
    
    .ripple {
        position: absolute;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.3);
        transform: scale(0);
        animation: ripple-animation 0.6s linear;
        pointer-events: none;
    }
    
    @keyframes ripple-animation {
        to {
            transform: scale(4);
            opacity: 0;
        }
    }
`
document.head.appendChild(style)

// Keyboard navigation
document.addEventListener("keydown", (e) => {
  if (e.key === "Enter") {
    const activeElement = document.activeElement
    if (activeElement.tagName === "INPUT") {
      const form = activeElement.closest("form")
      if (form) {
        const submitButton = form.querySelector('button[type="submit"]')
        if (submitButton) {
          submitButton.click()
        }
      }
    }
  }
})
