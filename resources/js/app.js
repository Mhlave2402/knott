// FILE: resources/js/app.js

import './bootstrap';
import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

// Mobile menu functionality
window.toggleMobileMenu = function() {
    const menu = document.getElementById('mobile-menu');
    const isHidden = menu.style.display === 'none' || menu.style.display === '';
    menu.style.display = isHidden ? 'flex' : 'none';
}

// Dropdown functionality
window.toggleDropdown = function() {
    const dropdown = document.getElementById('dropdown-menu');
    dropdown.classList.toggle('hidden');
}

// Close dropdown when clicking outside
document.addEventListener('click', function(event) {
    const dropdown = document.getElementById('dropdown-menu');
    const button = document.getElementById('user-menu-button');
    
    if (dropdown && button && !button.contains(event.target) && !dropdown.contains(event.target)) {
        dropdown.classList.add('hidden');
    }
});

// Search functionality
window.initSearch = function() {
    const searchInput = document.querySelector('input[name="search"]');
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            // TODO: Implement search functionality in Phase 2
            console.log('Search query:', this.value);
        });
    }
}

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    initSearch();
    
    // Add loading states to forms
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function() {
            const submitBtn = form.querySelector('button[type="submit"]');
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.innerHTML = `
                    <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Processing...
                `;
            }
        });
    });
    
    // Auto-hide flash messages
    const flashMessages = document.querySelectorAll('[class*="bg-green-50"], [class*="bg-red-50"]');
    flashMessages.forEach(message => {
        setTimeout(() => {
            message.style.transition = 'opacity 0.5s ease-out';
            message.style.opacity = '0';
            setTimeout(() => {
                message.remove();
            }, 500);
        }, 5000);
    });
});

// Utility functions for future phases
window.KnottUtils = {
    // Format currency for South African Rand
    formatCurrency: function(amount) {
        return new Intl.NumberFormat('en-ZA', {
            style: 'currency',
            currency: 'ZAR',
            minimumFractionDigits: 0
        }).format(amount);
    },
    
    // Calculate days until wedding
    daysUntilWedding: function(weddingDate) {
        const today = new Date();
        const wedding = new Date(weddingDate);
        const diffTime = wedding - today;
        return Math.ceil(diffTime / (1000 * 60 * 60 * 24));
    },
    
    // Show notification
    showNotification: function(message, type = 'info') {
        // TODO: Implement notification system
        console.log(`${type}: ${message}`);
    },
    
    // Validate South African phone number
    validatePhoneNumber: function(phone) {
        const saPhoneRegex = /^(\+27|0)[1-9][0-9]{8}$/;
        return saPhoneRegex.test(phone);
    }
};