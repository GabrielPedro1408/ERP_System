document.addEventListener("DOMContentLoaded", () => {

    const ScrollReveal = window.ScrollReveal
    const sr = ScrollReveal({
    origin: "bottom",
    distance: "60px",
    duration: 1000,
    delay: 200,
    easing: "ease-in-out",
    reset: false,
    })


    sr.reveal(".hero-title", { delay: 300 })
    sr.reveal(".hero-subtitle", { delay: 500 })
    sr.reveal(".btn-primary", { delay: 700 })
    sr.reveal(".carousel-container", { delay: 900 })

    sr.reveal(".section-title", { delay: 200 })
    sr.reveal(".about-description", { delay: 400 })
    sr.reveal(".feature-item", {
    delay: 200,
    interval: 100,
    })
    sr.reveal(".about-image", {
    delay: 600,
    origin: "right",
    })

    sr.reveal(".plan-card", {
    delay: 200,
    interval: 200,
    })

    document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
    anchor.addEventListener("click", function (e) {
        e.preventDefault()
        const target = document.querySelector(this.getAttribute("href"))
        if (target) {
        const headerHeight = document.querySelector(".header").offsetHeight
        const targetPosition = target.offsetTop - headerHeight

        window.scrollTo({
            top: targetPosition,
            behavior: "smooth",
        })
        }
    })
    })

    window.addEventListener("scroll", () => {
    const header = document.querySelector(".header")
    if (window.scrollY > 100) {
        header.style.background = "rgba(4, 41, 64, 0.98)"
    } else {
        header.style.background = "rgba(4, 41, 64, 0.95)"
    }
    })
    })

    let slideIndex = 1
    showSlide(slideIndex)

    setInterval(() => {
    slideIndex++
    if (slideIndex > 3) {
    slideIndex = 1
    }
    showSlide(slideIndex)
    }, 4000)

    function currentSlide(n) {
    showSlide((slideIndex = n))
    }

    function showSlide(n) {
    const slides = document.querySelectorAll(".carousel-slide")
    const dots = document.querySelectorAll(".dot")

    if (n > slides.length) {
    slideIndex = 1
    }
    if (n < 1) {
    slideIndex = slides.length
    }

    // Hide all slides
    slides.forEach((slide) => {
    slide.classList.remove("active")
    })

    // Remove active class from all dots
    dots.forEach((dot) => {
    dot.classList.remove("active")
    })

    // Show current slide and activate corresponding dot
    if (slides[slideIndex - 1]) {
    slides[slideIndex - 1].classList.add("active")
    }
    if (dots[slideIndex - 1]) {
    dots[slideIndex - 1].classList.add("active")
    }
    }
    window.addEventListener("load", () => {
    document.body.classList.add("loaded")
    })

    function toggleMobileMenu() {
    const nav = document.querySelector(".nav")
    nav.classList.toggle("mobile-active")
    }

    const observerOptions = {
    threshold: 0.1,
    rootMargin: "0px 0px -50px 0px",
    }

    const observer = new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
    if (entry.isIntersecting) {
        entry.target.classList.add("animate")
    }
    })
    }, observerOptions)

    document.querySelectorAll(".plan-card, .feature-item").forEach((el) => {
    observer.observe(el)
    })

    document.querySelectorAll(".plan-card").forEach((card) => {
    card.addEventListener("mouseenter", function () {
    this.style.transform = "translateY(-15px) scale(1.02)"
    })

    card.addEventListener("mouseleave", function () {
    this.style.transform = "translateY(0) scale(1)"
    })
    })

    document.querySelectorAll(".btn-primary, .btn-login, .plan-btn").forEach((btn) => {
    btn.addEventListener("click", function (e) {
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

    const style = document.createElement("style")
    style.textContent = `
    .btn-primary, .btn-login, .plan-btn {
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