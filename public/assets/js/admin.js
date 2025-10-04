// Premium Admin Theme V2 - Interactive Features
(function() {
    'use strict';
    
    // Theme management
    const ThemeManager = {
        init() {
            this.themeBtn = document.querySelector('.js-theme-toggle');
            this.body = document.body;
            this.currentTheme = localStorage.getItem('admin-theme') || 'light';
            
            this.applyTheme(this.currentTheme);
            this.bindEvents();
        },
        
        bindEvents() {
            if (this.themeBtn) {
                this.themeBtn.addEventListener('click', () => this.toggleTheme());
            }
        },
        
        toggleTheme() {
            const newTheme = this.currentTheme === 'light' ? 'dark' : 'light';
            this.applyTheme(newTheme);
        },
        
        applyTheme(theme) {
            this.currentTheme = theme;
            
            if (theme === 'dark') {
                this.body.classList.add('theme-dark');
            } else {
                this.body.classList.remove('theme-dark');
            }
            
            localStorage.setItem('admin-theme', theme);
            this.updateThemeIcon();
        },
        
        updateThemeIcon() {
            if (!this.themeBtn) return;
            
            const icon = this.themeBtn.querySelector('i');
            if (this.currentTheme === 'dark') {
                icon.className = 'fa-solid fa-sun';
            } else {
                icon.className = 'fa-solid fa-palette';
            }
        }
    };
    
    // Mobile menu management
    const MobileMenu = {
        init() {
            this.toggleBtn = document.querySelector('.js-mobile-toggle');
            this.sidebar = document.querySelector('.admin-sidebar');
            this.overlay = null;
            
            this.bindEvents();
        },
        
        bindEvents() {
            if (this.toggleBtn) {
                this.toggleBtn.addEventListener('click', () => this.toggle());
            }
            
            // Close on overlay click
            document.addEventListener('click', (e) => {
                if (this.overlay && e.target === this.overlay) {
                    this.close();
                }
            });
            
            // Close on escape key
            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape' && this.isOpen()) {
                    this.close();
                }
            });
        },
        
        toggle() {
            if (this.isOpen()) {
                this.close();
            } else {
                this.open();
            }
        },
        
        open() {
            if (!this.sidebar) return;
            
            this.sidebar.classList.add('active');
            this.createOverlay();
        },
        
        close() {
            if (!this.sidebar) return;
            
            this.sidebar.classList.remove('active');
            this.removeOverlay();
        },
        
        isOpen() {
            return this.sidebar && this.sidebar.classList.contains('active');
        },
        
        createOverlay() {
            if (this.overlay) return;
            
            this.overlay = document.createElement('div');
            this.overlay.style.cssText = `
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: rgba(0, 0, 0, 0.5);
                z-index: 39;
                backdrop-filter: blur(4px);
            `;
            
            document.body.appendChild(this.overlay);
        },
        
        removeOverlay() {
            if (this.overlay) {
                this.overlay.remove();
                this.overlay = null;
            }
        }
    };
    
    // Search functionality
    const Search = {
        init() {
            this.input = document.querySelector('.admin-search-input');
            this.bindEvents();
        },
        
        bindEvents() {
            if (this.input) {
                // Focus search with Cmd/Ctrl + K
                document.addEventListener('keydown', (e) => {
                    if ((e.metaKey || e.ctrlKey) && e.key === 'k') {
                        e.preventDefault();
                        this.input.focus();
                    }
                });
                
                // Clear search on escape
                this.input.addEventListener('keydown', (e) => {
                    if (e.key === 'Escape') {
                        this.input.blur();
                        this.input.value = '';
                    }
                });
            }
        }
    };
    
    // Navigation active state management
    const Navigation = {
        init() {
            this.setActiveNavLink();
        },
        
        setActiveNavLink() {
            const currentPath = window.location.pathname;
            const navLinks = document.querySelectorAll('.admin-nav-link');
            
            navLinks.forEach(link => {
                link.classList.remove('active');
                
                const linkPath = new URL(link.href).pathname;
                if (currentPath === linkPath || 
                    (linkPath !== '/admin' && currentPath.startsWith(linkPath))) {
                    link.classList.add('active');
                }
            });
        }
    };
    
    // Notification badge animation
    const Notifications = {
        init() {
            this.badge = document.querySelector('.admin-badge');
            this.animateBadge();
        },
        
        animateBadge() {
            if (!this.badge) return;
            
            // Add a subtle pulse animation
            setInterval(() => {
                this.badge.style.transform = 'scale(1.1)';
                setTimeout(() => {
                    this.badge.style.transform = 'scale(1)';
                }, 200);
            }, 3000);
        }
    };
    
    // Enhanced card hover effects
    const CardEffects = {
        init() {
            this.cards = document.querySelectorAll('.card, .admin-stat-card');
            this.bindEvents();
        },
        
        bindEvents() {
            this.cards.forEach(card => {
                card.addEventListener('mouseenter', () => {
                    card.style.transform = 'translateY(-2px)';
                });
                
                card.addEventListener('mouseleave', () => {
                    card.style.transform = 'translateY(0)';
                });
            });
        }
    };
    
    // Initialize all modules when DOM is ready
    document.addEventListener('DOMContentLoaded', function() {
        ThemeManager.init();
        MobileMenu.init();
        Search.init();
        Navigation.init();
        Notifications.init();
        CardEffects.init();
        
        // Add smooth scrolling for internal links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth'
                    });
                }
            });
        });
        
        console.log('🎨 Premium Admin Theme V2 loaded');
    });
    
})();