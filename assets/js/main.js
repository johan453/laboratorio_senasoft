// assets/js/main.js

document.addEventListener('DOMContentLoaded', function() {
    // Configuración de Particles.js
    particlesJS('particles-js', {
        particles: {
            number: {
                value: 80,
                density: {
                    enable: true,
                    value_area: 800
                }
            },
            color: {
                value: '#3498db'
            },
            shape: {
                type: 'circle'
            },
            opacity: {
                value: 0.5,
                random: false
            },
            size: {
                value: 3,
                random: true
            },
            line_linked: {
                enable: true,
                distance: 150,
                color: '#3498db',
                opacity: 0.4,
                width: 1
            },
            move: {
                enable: true,
                speed: 2,
                direction: 'none',
                random: false,
                straight: false,
                out_mode: 'out',
                bounce: false
            }
        },
        interactivity: {
            detect_on: 'canvas',
            events: {
                onhover: {
                    enable: true,
                    mode: 'grab'
                },
                onclick: {
                    enable: true,
                    mode: 'push'
                },
                resize: true
            }
        },
        retina_detect: true
    });

    // Añadir animaciones al hacer scroll
    const animateOnScroll = () => {
        const elements = document.querySelectorAll('.animate__animated');
        elements.forEach(element => {
            const elementPosition = element.getBoundingClientRect().top;
            const screenPosition = window.innerHeight;
            
            if(elementPosition < screenPosition) {
                if(!element.classList.contains('animate__fadeIn')) {
                    element.classList.add('animate__fadeIn');
                }
            }
        });
    };

    // Event listeners
    window.addEventListener('scroll', animateOnScroll);
    
    // Inicializar tooltips de Bootstrap
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    const tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Añadir efecto de carga
    const addLoadingEffect = (button) => {
        button.addEventListener('click', function(e) {
            const originalContent = this.innerHTML;
            this.innerHTML = '<div class="loading-spinner"></div>';
            setTimeout(() => {
                this.innerHTML = originalContent;
            }, 1000);
        });
    };

    // Aplicar efecto de carga a todos los botones
    document.querySelectorAll('.btn').forEach(addLoadingEffect);
});