/**
 * FAQ Section JavaScript - Interactive FAQ Functionality
 * 
 * Handles accordion behavior, search functionality, category filtering,
 * and analytics tracking for the FAQ section.
 * 
 * @version 1.0
 * @since 2025-07-18
 */

class FAQSection {
    constructor() {
        this.initializeElements();
        this.attachEventListeners();
        this.initializeSearch();
        this.trackAnalytics();
    }

    /**
     * Initialize DOM elements
     */
    initializeElements() {
        this.faqSection = document.getElementById('faq-section');
        this.faqItems = document.querySelectorAll('.faq-item');
        this.searchInput = document.getElementById('faq-search');
        this.mobileSearchInput = document.getElementById('faq-mobile-search');
        this.searchSuggestions = document.getElementById('faq-suggestions');
        this.categoryButtons = document.querySelectorAll('.category-btn');
        this.searchButton = document.querySelector('.search-button');
        
        // Initialize state
        this.searchTimeout = null;
        this.currentCategory = 'all';
        this.analytics = {
            pageLoaded: Date.now(),
            faqInteractions: 0,
            searchQueries: 0,
            categoryFilters: 0
        };
    }

    /**
     * Attach event listeners
     */
    attachEventListeners() {
        // FAQ accordion functionality
        this.faqItems.forEach(item => {
            const question = item.querySelector('.faq-question');
            const toggle = item.querySelector('.faq-toggle');
            
            question.addEventListener('click', () => this.toggleFAQ(item));
            toggle.addEventListener('click', (e) => {
                e.stopPropagation();
                this.toggleFAQ(item);
            });
        });

        // Search functionality
        if (this.searchInput) {
            this.searchInput.addEventListener('input', (e) => this.handleSearch(e.target.value));
            this.searchInput.addEventListener('focus', () => this.showSearchSuggestions());
            this.searchInput.addEventListener('blur', () => this.hideSearchSuggestions());
        }

        if (this.mobileSearchInput) {
            this.mobileSearchInput.addEventListener('input', (e) => this.handleMobileSearch(e.target.value));
        }

        if (this.searchButton) {
            this.searchButton.addEventListener('click', () => this.performSearch());
        }

        // Category filtering
        this.categoryButtons.forEach(button => {
            button.addEventListener('click', () => this.filterByCategory(button.dataset.category));
        });

        // Keyboard navigation
        document.addEventListener('keydown', (e) => this.handleKeyboardNavigation(e));

        // Window resize handling
        window.addEventListener('resize', () => this.handleResize());
    }

    /**
     * Toggle FAQ item expansion
     * @param {Element} item FAQ item element
     */
    toggleFAQ(item) {
        const isExpanded = item.classList.contains('expanded');
        const answer = item.querySelector('.faq-answer');
        const toggle = item.querySelector('.faq-toggle');
        
        if (isExpanded) {
            // Collapse
            item.classList.remove('expanded');
            answer.style.maxHeight = '0';
            toggle.setAttribute('aria-expanded', 'false');
        } else {
            // Expand
            item.classList.add('expanded');
            answer.style.maxHeight = answer.scrollHeight + 'px';
            toggle.setAttribute('aria-expanded', 'true');
            
            // Track interaction
            this.analytics.faqInteractions++;
            this.trackFAQInteraction(item);
        }

        // Smooth scroll to question if needed
        if (!isExpanded) {
            setTimeout(() => {
                const rect = item.getBoundingClientRect();
                const isVisible = rect.top >= 0 && rect.bottom <= window.innerHeight;
                
                if (!isVisible) {
                    item.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            }, 100);
        }
    }

    /**
     * Handle search input
     * @param {string} query Search query
     */
    handleSearch(query) {
        clearTimeout(this.searchTimeout);
        
        this.searchTimeout = setTimeout(() => {
            this.performSearch(query);
            this.updateSearchSuggestions(query);
        }, 300);
    }

    /**
     * Handle mobile search
     * @param {string} query Search query
     */
    handleMobileSearch(query) {
        clearTimeout(this.searchTimeout);
        
        this.searchTimeout = setTimeout(() => {
            if (query.length >= 2) {
                // Redirect to full FAQ page with search
                window.location.href = `/faq?search=${encodeURIComponent(query)}`;
            }
        }, 500);
    }

    /**
     * Perform search functionality
     * @param {string} query Search query (optional)
     */
    performSearch(query = null) {
        const searchQuery = query || this.searchInput?.value || '';
        
        if (searchQuery.length < 2) {
            this.showAllFAQs();
            return;
        }

        this.analytics.searchQueries++;
        
        // Filter FAQs based on search query
        this.faqItems.forEach(item => {
            const question = item.querySelector('.faq-question h3').textContent.toLowerCase();
            const answer = item.querySelector('.faq-content p').textContent.toLowerCase();
            const tags = Array.from(item.querySelectorAll('.faq-tag')).map(tag => tag.textContent.toLowerCase());
            
            const searchText = [question, answer, ...tags].join(' ');
            const matches = searchQuery.toLowerCase().split(' ').every(term => 
                searchText.includes(term)
            );
            
            if (matches) {
                item.style.display = 'block';
                this.highlightSearchTerms(item, searchQuery);
            } else {
                item.style.display = 'none';
            }
        });

        // Track search
        this.trackSearch(searchQuery);
    }

    /**
     * Show all FAQs (clear filters)
     */
    showAllFAQs() {
        this.faqItems.forEach(item => {
            item.style.display = 'block';
            this.clearHighlights(item);
        });
    }

    /**
     * Highlight search terms in FAQ content
     * @param {Element} item FAQ item
     * @param {string} query Search query
     */
    highlightSearchTerms(item, query) {
        const question = item.querySelector('.faq-question h3');
        const answer = item.querySelector('.faq-content p');
        
        const terms = query.toLowerCase().split(' ').filter(term => term.length > 1);
        
        [question, answer].forEach(element => {
            if (element) {
                let html = element.innerHTML;
                
                terms.forEach(term => {
                    const regex = new RegExp(`(${this.escapeRegex(term)})`, 'gi');
                    html = html.replace(regex, '<mark class="search-highlight">$1</mark>');
                });
                
                element.innerHTML = html;
            }
        });
    }

    /**
     * Clear search highlights
     * @param {Element} item FAQ item
     */
    clearHighlights(item) {
        const highlights = item.querySelectorAll('.search-highlight');
        highlights.forEach(highlight => {
            highlight.outerHTML = highlight.innerHTML;
        });
    }

    /**
     * Filter FAQs by category
     * @param {string} category Category slug
     */
    filterByCategory(category) {
        this.currentCategory = category;
        this.analytics.categoryFilters++;
        
        // Update active button
        this.categoryButtons.forEach(btn => {
            btn.classList.toggle('active', btn.dataset.category === category);
        });
        
        // Filter FAQs
        if (category === 'all') {
            this.showAllFAQs();
        } else {
            this.faqItems.forEach(item => {
                const itemCategory = item.dataset.category;
                if (itemCategory === category) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });
        }

        // Track category filter
        this.trackCategoryFilter(category);
    }

    /**
     * Initialize search suggestions
     */
    initializeSearch() {
        this.searchSuggestions = [
            'legal gambling age',
            'online casino safety',
            'bonus wagering requirements',
            'withdrawal processing time',
            'payment methods canada',
            'offshore casino legal',
            'casino license verification',
            'responsible gambling tools'
        ];
    }

    /**
     * Update search suggestions based on query
     * @param {string} query Search query
     */
    updateSearchSuggestions(query) {
        if (!this.searchSuggestions || query.length < 2) {
            this.hideSearchSuggestions();
            return;
        }

        const suggestions = this.searchSuggestions.filter(suggestion =>
            suggestion.toLowerCase().includes(query.toLowerCase())
        );

        if (suggestions.length > 0) {
            this.displaySearchSuggestions(suggestions);
        } else {
            this.hideSearchSuggestions();
        }
    }

    /**
     * Display search suggestions
     * @param {Array} suggestions Array of suggestion strings
     */
    displaySearchSuggestions(suggestions) {
        if (!this.searchSuggestions) return;

        const html = suggestions.slice(0, 5).map(suggestion => 
            `<div class="suggestion-item" data-suggestion="${suggestion}">${suggestion}</div>`
        ).join('');

        this.searchSuggestions.innerHTML = html;
        this.searchSuggestions.style.display = 'block';

        // Add click handlers to suggestions
        this.searchSuggestions.querySelectorAll('.suggestion-item').forEach(item => {
            item.addEventListener('click', () => {
                this.searchInput.value = item.dataset.suggestion;
                this.performSearch(item.dataset.suggestion);
                this.hideSearchSuggestions();
            });
        });
    }

    /**
     * Show search suggestions
     */
    showSearchSuggestions() {
        if (this.searchInput?.value.length >= 2) {
            this.updateSearchSuggestions(this.searchInput.value);
        }
    }

    /**
     * Hide search suggestions
     */
    hideSearchSuggestions() {
        setTimeout(() => {
            if (this.searchSuggestions) {
                this.searchSuggestions.style.display = 'none';
            }
        }, 200);
    }

    /**
     * Handle keyboard navigation
     * @param {KeyboardEvent} e Keyboard event
     */
    handleKeyboardNavigation(e) {
        // Escape key to close expanded FAQs or clear search
        if (e.key === 'Escape') {
            if (this.searchInput?.value) {
                this.searchInput.value = '';
                this.showAllFAQs();
            } else {
                this.faqItems.forEach(item => {
                    if (item.classList.contains('expanded')) {
                        this.toggleFAQ(item);
                    }
                });
            }
        }

        // Enter key on search
        if (e.key === 'Enter' && e.target === this.searchInput) {
            this.performSearch();
            this.hideSearchSuggestions();
        }
    }

    /**
     * Handle window resize
     */
    handleResize() {
        // Adjust FAQ answer heights on resize
        this.faqItems.forEach(item => {
            if (item.classList.contains('expanded')) {
                const answer = item.querySelector('.faq-answer');
                answer.style.maxHeight = answer.scrollHeight + 'px';
            }
        });
    }

    /**
     * Track FAQ interaction for analytics
     * @param {Element} item FAQ item
     */
    trackFAQInteraction(item) {
        const faqId = item.dataset.faqId;
        const question = item.querySelector('.faq-question h3').textContent;
        
        // Track with analytics service (if available)
        if (typeof gtag !== 'undefined') {
            gtag('event', 'faq_interaction', {
                event_category: 'FAQ',
                event_label: question,
                faq_id: faqId,
                section: 'homepage'
            });
        }
        
        console.log('FAQ Interaction:', {
            faq_id: faqId,
            question: question,
            timestamp: new Date().toISOString()
        });
    }

    /**
     * Track search queries
     * @param {string} query Search query
     */
    trackSearch(query) {
        if (typeof gtag !== 'undefined') {
            gtag('event', 'faq_search', {
                event_category: 'FAQ',
                event_label: query,
                search_term: query,
                section: 'homepage'
            });
        }
        
        console.log('FAQ Search:', {
            query: query,
            timestamp: new Date().toISOString()
        });
    }

    /**
     * Track category filtering
     * @param {string} category Category name
     */
    trackCategoryFilter(category) {
        if (typeof gtag !== 'undefined') {
            gtag('event', 'faq_category_filter', {
                event_category: 'FAQ',
                event_label: category,
                category: category,
                section: 'homepage'
            });
        }
        
        console.log('FAQ Category Filter:', {
            category: category,
            timestamp: new Date().toISOString()
        });
    }

    /**
     * Track general analytics
     */
    trackAnalytics() {
        // Track section visibility
        if ('IntersectionObserver' in window) {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        this.trackSectionView();
                        observer.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.5 });

            if (this.faqSection) {
                observer.observe(this.faqSection);
            }
        }

        // Track time spent in section
        let sectionVisible = false;
        let visibilityStart = 0;

        const visibilityObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting && !sectionVisible) {
                    sectionVisible = true;
                    visibilityStart = Date.now();
                } else if (!entry.isIntersecting && sectionVisible) {
                    sectionVisible = false;
                    const timeSpent = Date.now() - visibilityStart;
                    this.trackTimeSpent(timeSpent);
                }
            });
        });

        if (this.faqSection) {
            visibilityObserver.observe(this.faqSection);
        }
    }

    /**
     * Track section view
     */
    trackSectionView() {
        if (typeof gtag !== 'undefined') {
            gtag('event', 'section_view', {
                event_category: 'FAQ',
                event_label: 'FAQ Section Viewed',
                section: 'homepage'
            });
        }
    }

    /**
     * Track time spent in section
     * @param {number} timeMs Time in milliseconds
     */
    trackTimeSpent(timeMs) {
        const timeSeconds = Math.round(timeMs / 1000);
        
        if (typeof gtag !== 'undefined') {
            gtag('event', 'time_spent', {
                event_category: 'FAQ',
                event_label: 'Time in FAQ Section',
                value: timeSeconds,
                section: 'homepage'
            });
        }
        
        console.log('FAQ Time Spent:', {
            time_seconds: timeSeconds,
            interactions: this.analytics.faqInteractions,
            searches: this.analytics.searchQueries,
            filters: this.analytics.categoryFilters
        });
    }

    /**
     * Escape regex special characters
     * @param {string} string String to escape
     * @returns {string} Escaped string
     */
    escapeRegex(string) {
        return string.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
    }

    /**
     * Get FAQ analytics data
     * @returns {Object} Analytics data
     */
    getAnalytics() {
        return {
            ...this.analytics,
            timeOnPage: Date.now() - this.analytics.pageLoaded,
            currentCategory: this.currentCategory
        };
    }
}

// Initialize FAQ section when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    const faqSection = document.getElementById('faq-section');
    if (faqSection) {
        window.faqSectionInstance = new FAQSection();
    }
});

// Export for module systems
if (typeof module !== 'undefined' && module.exports) {
    module.exports = FAQSection;
}
