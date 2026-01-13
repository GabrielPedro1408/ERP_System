// Current step tracking
let currentStep = 1
const totalSteps = 3

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

  // Reveal cadastro container
  sr.reveal(".cadastro-container", { delay: 200 })

  // Initialize form
  initializeForm()

  // Ensure first step is active
  updateStep()

  // Debug
  console.log("Steps encontrados:", document.querySelectorAll(".step-content").length)
  document.querySelectorAll(".step-content").forEach((step, index) => {
    console.log(`Step ${index + 1} data-step:`, step.getAttribute("data-step"))
  })
})

// Initialize form functionality
function initializeForm() {
  // Add input event listeners for real-time validation
  const inputs = document.querySelectorAll("input")
  inputs.forEach((input) => {
    input.addEventListener("input", validateInput)
    input.addEventListener("blur", validateInput)
  })

  // Password validation
  const senhaInput = document.getElementById("senhaUsuario")
  if (senhaInput) {
    senhaInput.addEventListener("input", validatePassword)
  }

  // CEP auto-complete
  const cepInput = document.getElementById("cepEmpresa")
  if (cepInput) {
    cepInput.addEventListener("blur", autoCompleteCEP)
  }

  // Form submission
  const form = document.getElementById("cadastroForm")
  if (form) {
    form.addEventListener("submit", handleFormSubmit)
  }

  // Initialize masks
  initializeMasks()
}

// Input validation
function validateInput(e) {
  const input = e.target
  const value = input.value.trim()

  // Remove previous validation classes
  input.classList.remove("valid", "invalid")

  if (input.hasAttribute("required") && !value) {
    input.classList.add("invalid")
    return false
  }

  // Email validation
  if (input.type === "email") {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/
    if (!emailRegex.test(value)) {
      input.classList.add("invalid")
      return false
    }
  }

  // CNPJ validation
  if (input.name === "cnpjEmpresa") {
    if (!validateCNPJ(value)) {
      input.classList.add("invalid")
      return false
    }
  }

  input.classList.add("valid")
  return true
}

// Password validation
function validatePassword() {
  const password = document.getElementById("senhaUsuario").value
  const requirements = {
    length: password.length >= 8,
    uppercase: /[A-Z]/.test(password),
    lowercase: /[a-z]/.test(password),
    number: /\d/.test(password),
  }

  // Update visual indicators
  Object.keys(requirements).forEach((req) => {
    const element = document.getElementById(req)
    if (element) {
      element.classList.toggle("valid", requirements[req])
    }
  })

  return Object.values(requirements).every((req) => req)
}

// CNPJ validation
function validateCNPJ(cnpj) {
  cnpj = cnpj.replace(/[^\d]+/g, "")

  if (cnpj.length !== 14) return false

  // Validate check digits
  let tamanho = cnpj.length - 2
  let numeros = cnpj.substring(0, tamanho)
  const digitos = cnpj.substring(tamanho)
  let soma = 0
  let pos = tamanho - 7

  for (let i = tamanho; i >= 1; i--) {
    soma += numeros.charAt(tamanho - i) * pos--
    if (pos < 2) pos = 9
  }

  let resultado = soma % 11 < 2 ? 0 : 11 - (soma % 11)
  if (resultado != digitos.charAt(0)) return false

  tamanho = tamanho + 1
  numeros = cnpj.substring(0, tamanho)
  soma = 0
  pos = tamanho - 7

  for (let i = tamanho; i >= 1; i--) {
    soma += numeros.charAt(tamanho - i) * pos--
    if (pos < 2) pos = 9
  }

  resultado = soma % 11 < 2 ? 0 : 11 - (soma % 11)
  if (resultado != digitos.charAt(1)) return false

  return true
}

// Auto-complete CEP
async function autoCompleteCEP(e) {
  const cep = e.target.value.replace(/\D/g, "")

  if (cep.length === 8) {
    try {
      const response = await fetch(`https://viacep.com.br/ws/${cep}/json/`)
      const data = await response.json()

      if (!data.erro) {
        document.getElementById("ruaEmpresa").value = data.logradouro || ""
        document.getElementById("cidadeEmpresa").value = data.localidade || ""
        document.getElementById("ufEmpresa").value = data.uf || ""
      }
    } catch (error) {
      console.error("Erro ao buscar CEP:", error)
    }
  }
}

// Initialize input masks
function initializeMasks() {
  // Phone mask
  const phoneInput = document.getElementById("telefoneEmpresa")
  if (phoneInput) {
    phoneInput.addEventListener("input", (e) => {
      let value = e.target.value.replace(/\D/g, "")
      value = value.replace(/^(\d{2})(\d)/g, "($1) $2")
      value = value.replace(/(\d)(\d{4})$/, "$1-$2")
      e.target.value = value
    })
  }

  // CNPJ mask
  const cnpjInput = document.getElementById("cnpjEmpresa")
  if (cnpjInput) {
    cnpjInput.addEventListener("input", (e) => {
      let value = e.target.value.replace(/\D/g, "")
      value = value.replace(/^(\d{2})(\d)/, "$1.$2")
      value = value.replace(/^(\d{2})\.(\d{3})(\d)/, "$1.$2.$3")
      value = value.replace(/\.(\d{3})(\d)/, ".$1/$2")
      value = value.replace(/(\d{4})(\d)/, "$1-$2")
      e.target.value = value
    })
  }

  // CEP mask
  const cepInput = document.getElementById("cepEmpresa")
  if (cepInput) {
    cepInput.addEventListener("input", (e) => {
      let value = e.target.value.replace(/\D/g, "")
      value = value.replace(/^(\d{5})(\d)/, "$1-$2")
      e.target.value = value
    })
  }
}

// Navigation functions
function nextStep() {
  if (validateCurrentStep()) {
    if (currentStep < totalSteps) {
      currentStep++
      updateStep()
      updateSummary()
    }
  }
}

function prevStep() {
  if (currentStep > 1) {
    currentStep--
    updateStep()
  }
}

// Validate current step
function validateCurrentStep() {
  const currentStepElement = document.querySelector(`.step-content[data-step="${currentStep}"]`)
  if (!currentStepElement) {
    console.error(`Elemento step ${currentStep} não encontrado`)
    return false
  }

  const inputs = currentStepElement.querySelectorAll("input[required]")
  let isValid = true

  inputs.forEach((input) => {
    if (!validateInput({ target: input })) {
      isValid = false
    }
  })

  // Additional validation for step 2
  if (currentStep === 2) {
    const senha = document.getElementById("senhaUsuario").value
    const confirmarSenha = document.getElementById("confirmarSenha").value

    if (senha !== confirmarSenha) {
      alert("As senhas não coincidem!")
      isValid = false
    }

    if (!validatePassword()) {
      alert("A senha não atende aos requisitos mínimos!")
      isValid = false
    }
  }

  return isValid
}

// Update step display
function updateStep() {
  // Update step content
  document.querySelectorAll(".step-content").forEach((step) => {
    step.classList.remove("active")
  })

  const activeStep = document.querySelector(`.step-content[data-step="${currentStep}"]`)
  if (activeStep) {
    activeStep.classList.add("active")
    console.log(`Ativando step ${currentStep}`)
  } else {
    console.error(`Step ${currentStep} não encontrado`)
  }

  // Update progress bar
  document.querySelectorAll(".progress-step").forEach((step, index) => {
    const stepNumber = index + 1
    step.classList.remove("active", "completed")

    if (stepNumber < currentStep) {
      step.classList.add("completed")
    } else if (stepNumber === currentStep) {
      step.classList.add("active")
    }
  })

  // Update progress fill
  const progressFills = document.querySelectorAll(".progress-fill")
  progressFills.forEach((fill, index) => {
    if (index < currentStep - 1) {
      fill.style.width = "100%"
    } else {
      fill.style.width = "0%"
    }
  })
}

// Update summary
function updateSummary() {
  if (currentStep === 3) {
    document.getElementById("summaryRazaoSocial").textContent = document.getElementById("razaoSocial").value || "-"
    document.getElementById("summaryEmail").textContent = document.getElementById("emailEmpresa").value || "-"
    document.getElementById("summaryCnpj").textContent = document.getElementById("cnpjEmpresa").value || "-"
    document.getElementById("summaryTelefone").textContent = document.getElementById("telefoneEmpresa").value || "-"
    document.getElementById("summaryUsuario").textContent = document.getElementById("usuario").value || "-"
  }
}

// Toggle password visibility
function togglePassword(inputId) {
  const input = document.getElementById(inputId)
  const icon = input.nextElementSibling.querySelector("i")

  if (input.type === "password") {
    input.type = "text"
    icon.classList.remove("fa-eye")
    icon.classList.add("fa-eye-slash")
  } else {
    input.type = "password"
    icon.classList.remove("fa-eye-slash")
    icon.classList.add("fa-eye")
  }
}

// Handle form submission
function handleFormSubmit(e) {

  if (!validateCurrentStep()) {
    return
  }

  // Check terms acceptance
  const termsCheckbox = document.querySelector('input[name="terms"]')
  if (!termsCheckbox.checked) {
    alert("Você deve aceitar os termos de uso para continuar.")
    return
  }

  // Show loading
  showLoading()

  // Simulate form submission
  setTimeout(() => {
    hideLoading()
    showSuccessModal()
  }, 3000)
}

// Show loading overlay
function showLoading() {
  document.getElementById("loadingOverlay").style.display = "flex"
}

// Hide loading overlay
function hideLoading() {
  document.getElementById("loadingOverlay").style.display = "none"
}

// Show success modal
function showSuccessModal() {
  document.getElementById("successModal").style.display = "flex"
}

// Redirect to login

// Add ripple effect to buttons
document.addEventListener("DOMContentLoaded", () => {
  const buttons = document.querySelectorAll(".btn-next, .btn-prev, .btn-submit, .btn-modal")

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
    .btn-next, .btn-prev, .btn-submit, .btn-modal {
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
    
    .input-field input.valid {
        border-color: #28a745;
    }
    
    .input-field input.invalid {
        border-color: #dc3545;
    }
`
document.head.appendChild(style)
