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
                document.documentElement.classList.add('theme-dark-loading');
            } else {
                this.body.classList.remove('theme-dark');
                document.documentElement.classList.remove('theme-dark-loading');
            }
            
            localStorage.setItem('admin-theme', theme);
            this.updateThemeIcon();
        },
        
        updateThemeIcon() {
            if (!this.themeBtn) return;
            const icon = this.themeBtn.querySelector('i');
            const isDark = this.currentTheme === 'dark';
            this.themeBtn.setAttribute('aria-pressed', isDark ? 'true' : 'false');
            icon.className = isDark ? 'fa-solid fa-toggle-on' : 'fa-solid fa-toggle-off';
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
    
    // Navigation active state management (exact match only)
    const Navigation = {
        init() {
            this.setActiveNavLink();
        },
        
        normalize(path) {
            if (!path) return '';
            let p = path.replace(/^\/?index\.php\//, '/');
            p = p.replace(/^\//, '').replace(/\/$/, '');
            const m = p.match(/(admin|instructor|client)(?:\/.*)?$/);
            if (m) p = m[0];
            return p;
        },
        
        setActiveNavLink() {
            const currentPath = this.normalize(window.location.pathname);
            const dataLinks = document.querySelectorAll('.admin-nav-link[data-path]');
            const allLinks = document.querySelectorAll('.admin-nav-link');
            allLinks.forEach(link => link.classList.remove('active'));
            if (dataLinks.length) {
                dataLinks.forEach(link => {
                    const linkPath = link.getAttribute('data-path');
                    if (currentPath === linkPath) link.classList.add('active');
                });
            } else {
                // Fallback: exact match on href path
                allLinks.forEach(link => {
                    try {
                        const linkPath = this.normalize(new URL(link.href).pathname);
                        if (currentPath === linkPath) link.classList.add('active');
                    } catch (e) { /* ignore */ }
                });
            }
        }
    };
    
    // Notifications disabled
    const Notifications = { init() {} };
    
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