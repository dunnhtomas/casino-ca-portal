/**
 * Popular Slots Detailed Section JavaScript
 * Handles filtering, demo games, analytics, and user interactions
 */

class SlotsManager {
    constructor() {
        this.slotsContainer = document.getElementById('slots-grid');
        this.filterControls = document.querySelector('.filter-controls');
        this.currentFilters = {};
        this.currentView = 'grid';
        this.loadMoreBtn = document.getElementById('load-more-slots');
        this.currentPage = 1;
        this.slotsPerPage = 16;
        
        this.init();
    }

    init() {
        this.bindEvents();
        this.setupModals();
        this.loadSlotImages();
    }

    bindEvents() {
        // Filter controls
        if (this.filterControls) {
            const applyBtn = this.filterControls.querySelector('#apply-filters');
            const clearBtn = this.filterControls.querySelector('#clear-filters');
            
            if (applyBtn) {
                applyBtn.addEventListener('click', () => this.applyFilters());
            }
            
            if (clearBtn) {
                clearBtn.addEventListener('click', () => this.clearFilters());
            }
            
            // Auto-apply filters on change
            const filterSelects = this.filterControls.querySelectorAll('select');
            filterSelects.forEach(select => {
                select.addEventListener('change', () => this.applyFilters());
            });
        }

        // View toggle
        const viewButtons = document.querySelectorAll('.view-btn');
        viewButtons.forEach(btn => {
            btn.addEventListener('click', (e) => {
                const view = e.target.dataset.view;
                this.switchView(view);
            });
        });

        // Demo buttons
        document.addEventListener('click', (e) => {
            if (e.target.classList.contains('demo-btn') || e.target.closest('.demo-btn')) {
                const btn = e.target.classList.contains('demo-btn') ? e.target : e.target.closest('.demo-btn');
                const slotId = btn.dataset.slotId;
                if (slotId) {
                    this.openDemoGame(slotId);
                }
            }
        });

        // Analytics buttons
        document.addEventListener('click', (e) => {
            if (e.target.classList.contains('analytics-btn') || e.target.closest('.analytics-btn')) {
                const btn = e.target.classList.contains('analytics-btn') ? e.target : e.target.closest('.analytics-btn');
                const slotId = btn.dataset.slotId;
                if (slotId) {
                    this.showAnalytics(slotId);
                }
            }
        });

        // Real money buttons
        document.addEventListener('click', (e) => {
            if (e.target.classList.contains('real-money-btn') || e.target.closest('.real-money-btn')) {
                const btn = e.target.classList.contains('real-money-btn') ? e.target : e.target.closest('.real-money-btn');
                const slotId = btn.dataset.slotId;
                if (slotId) {
                    this.redirectToRealMoney(slotId);
                }
            }
        });

        // Load more
        if (this.loadMoreBtn) {
            this.loadMoreBtn.addEventListener('click', () => this.loadMoreSlots());
        }

        // Keyboard navigation
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                this.closeModals();
            }
        });
    }

    setupModals() {
        // Demo modal
        const demoModal = document.getElementById('demo-modal');
        if (demoModal) {
            const closeBtn = demoModal.querySelector('.modal-close');
            if (closeBtn) {
                closeBtn.addEventListener('click', () => this.closeDemoModal());
            }
            
            // Close on background click
            demoModal.addEventListener('click', (e) => {
                if (e.target === demoModal) {
                    this.closeDemoModal();
                }
            });
        }

        // Analytics modal
        const analyticsModal = document.getElementById('analytics-modal');
        if (analyticsModal) {
            const closeBtn = analyticsModal.querySelector('.modal-close');
            if (closeBtn) {
                closeBtn.addEventListener('click', () => this.closeAnalyticsModal());
            }
            
            // Close on background click
            analyticsModal.addEventListener('click', (e) => {
                if (e.target === analyticsModal) {
                    this.closeAnalyticsModal();
                }
            });
        }
    }

    applyFilters() {
        const filters = {
            provider: document.getElementById('provider-filter')?.value || '',
            theme: document.getElementById('theme-filter')?.value || '',
            volatility: document.getElementById('volatility-filter')?.value || '',
            min_rtp: document.getElementById('rtp-filter')?.value || ''
        };

        this.currentFilters = filters;
        this.currentPage = 1;

        // Show loading state
        this.showLoading();

        // Make AJAX request to filter slots
        this.fetchFilteredSlots(filters)
            .then(data => {
                this.updateSlotsDisplay(data.slots);
                this.updateFiltersInfo(data);
            })
            .catch(error => {
                console.error('Filter error:', error);
                this.showError('Failed to filter slots. Please try again.');
            })
            .finally(() => {
                this.hideLoading();
            });
    }

    clearFilters() {
        // Reset all filter selects
        const filterSelects = this.filterControls.querySelectorAll('select');
        filterSelects.forEach(select => {
            select.value = '';
        });

        this.currentFilters = {};
        this.currentPage = 1;

        // Reload all slots
        this.applyFilters();
    }

    switchView(view) {
        this.currentView = view;
        
        // Update button states
        const viewButtons = document.querySelectorAll('.view-btn');
        viewButtons.forEach(btn => {
            btn.classList.toggle('active', btn.dataset.view === view);
        });

        // Update container class
        const container = document.querySelector('.slots-container');
        if (container) {
            container.className = `slots-container ${view}-view`;
        }
    }

    async fetchFilteredSlots(filters) {
        const url = new URL('/api/slots/filter', window.location.origin);
        Object.keys(filters).forEach(key => {
            if (filters[key]) {
                url.searchParams.append(key, filters[key]);
            }
        });

        const response = await fetch(url);
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        
        return await response.json();
    }

    updateSlotsDisplay(slots) {
        const container = document.querySelector('.slots-container');
        if (!container) return;

        if (slots.length === 0) {
            container.innerHTML = `
                <div class="no-results">
                    <h3>No slots found</h3>
                    <p>Try adjusting your filters to see more results.</p>
                    <button class="btn btn-primary" onclick="slotsManager.clearFilters()">
                        Clear All Filters
                    </button>
                </div>`;
            return;
        }

        // Generate slot cards
        container.innerHTML = slots.map(slot => this.generateSlotCard(slot)).join('');
        
        // Load images for new cards
        this.loadSlotImages();
    }

    generateSlotCard(slot) {
        const rtpClass = slot.rtp_percentage >= 96.5 ? 'excellent' : 
                        (slot.rtp_percentage >= 96 ? 'good' : 'fair');
        const volatilityClass = slot.volatility.toLowerCase();
        
        return `
            <div class="slot-card" data-slot-id="${slot.id}">
                <div class="slot-image">
                    <img src="${slot.thumbnail_image}" 
                         alt="${slot.name} slot game" 
                         loading="lazy"
                         onerror="this.src='/images/slots/placeholder.jpg'">
                    <div class="slot-overlay">
                        <button class="demo-btn" data-slot-id="${slot.id}">
                            <i class="icon-play"></i> Play Demo
                        </button>
                        <button class="real-money-btn" data-slot-id="${slot.id}">
                            <i class="icon-coins"></i> Play for Real
                        </button>
                    </div>
                </div>
                
                <div class="slot-info">
                    <h4 class="slot-name">${slot.name}</h4>
                    <p class="slot-provider">${slot.provider}</p>
                    
                    <div class="slot-stats">
                        <div class="stat-item">
                            <span class="stat-label">RTP:</span>
                            <span class="stat-value rtp-${rtpClass}">${slot.rtp_percentage}%</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-label">Volatility:</span>
                            <span class="stat-value volatility-${volatilityClass}">${slot.volatility}</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-label">Max Win:</span>
                            <span class="stat-value">${this.formatNumber(slot.max_win_multiplier)}x</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-label">Paylines:</span>
                            <span class="stat-value">${slot.paylines_count === 0 ? 'All Ways' : this.formatNumber(slot.paylines_count)}</span>
                        </div>
                    </div>
                    
                    <div class="slot-features">
                        <h5>Key Features:</h5>
                        <ul>
                            ${slot.bonus_features.slice(0, 3).map(feature => `<li>${feature}</li>`).join('')}
                        </ul>
                    </div>
                    
                    <div class="slot-theme">
                        <span class="theme-tag">${slot.theme_category}</span>
                    </div>
                    
                    <div class="slot-actions">
                        <button class="btn btn-primary demo-btn" data-slot-id="${slot.id}">
                            Try Free Demo
                        </button>
                        <button class="btn btn-secondary analytics-btn" data-slot-id="${slot.id}">
                            View Analytics
                        </button>
                    </div>
                </div>
            </div>`;
    }

    async openDemoGame(slotId) {
        try {
            const response = await fetch(`/api/slots/${slotId}/demo`);
            const data = await response.json();

            if (data.success && data.demo_url) {
                const modal = document.getElementById('demo-modal');
                const iframe = document.getElementById('demo-frame');
                
                if (modal && iframe) {
                    iframe.src = data.demo_url;
                    modal.classList.add('active');
                    document.body.style.overflow = 'hidden';
                    
                    // Track demo game launch
                    this.trackEvent('demo_game_launched', { slot_id: slotId });
                }
            } else {
                this.showNotification('Demo game not available for this slot.', 'warning');
            }
        } catch (error) {
            console.error('Demo game error:', error);
            this.showNotification('Failed to load demo game. Please try again.', 'error');
        }
    }

    async showAnalytics(slotId) {
        try {
            const response = await fetch(`/api/slots/${slotId}/analytics`);
            const data = await response.json();

            if (data.success && data.data) {
                const modal = document.getElementById('analytics-modal');
                const content = document.getElementById('analytics-content');
                
                if (modal && content) {
                    content.innerHTML = this.generateAnalyticsContent(data.data);
                    modal.classList.add('active');
                    document.body.style.overflow = 'hidden';
                    
                    // Track analytics view
                    this.trackEvent('analytics_viewed', { slot_id: slotId });
                }
            } else {
                this.showNotification('Analytics not available for this slot.', 'warning');
            }
        } catch (error) {
            console.error('Analytics error:', error);
            this.showNotification('Failed to load analytics. Please try again.', 'error');
        }
    }

    generateAnalyticsContent(analytics) {
        return `
            <div class="analytics-content">
                <div class="analytics-section">
                    <h4>Basic Information</h4>
                    <div class="info-grid">
                        <div class="info-item">
                            <label>Game Name:</label>
                            <span>${analytics.basic_info.name}</span>
                        </div>
                        <div class="info-item">
                            <label>Provider:</label>
                            <span>${analytics.basic_info.provider}</span>
                        </div>
                        <div class="info-item">
                            <label>Release Date:</label>
                            <span>${new Date(analytics.basic_info.release_date).toLocaleDateString()}</span>
                        </div>
                        <div class="info-item">
                            <label>Theme:</label>
                            <span>${analytics.basic_info.theme}</span>
                        </div>
                    </div>
                </div>

                <div class="analytics-section">
                    <h4>Mathematical Analysis</h4>
                    <div class="math-grid">
                        <div class="math-item">
                            <label>RTP (Return to Player):</label>
                            <span class="highlight">${analytics.mathematics.rtp_percentage}%</span>
                        </div>
                        <div class="math-item">
                            <label>Volatility:</label>
                            <span class="volatility-${analytics.mathematics.volatility.toLowerCase()}">${analytics.mathematics.volatility}</span>
                        </div>
                        <div class="math-item">
                            <label>Hit Frequency:</label>
                            <span>${analytics.mathematics.hit_frequency}</span>
                        </div>
                        <div class="math-item">
                            <label>Max Win:</label>
                            <span class="highlight">${this.formatNumber(analytics.mathematics.max_win)}x</span>
                        </div>
                    </div>
                </div>

                <div class="analytics-section">
                    <h4>Gameplay Details</h4>
                    <div class="gameplay-grid">
                        <div class="gameplay-item">
                            <label>Paylines:</label>
                            <span>${analytics.gameplay.paylines === 0 ? 'All Ways' : this.formatNumber(analytics.gameplay.paylines)}</span>
                        </div>
                        <div class="gameplay-item">
                            <label>Min Bet:</label>
                            <span>$${analytics.gameplay.min_bet}</span>
                        </div>
                        <div class="gameplay-item">
                            <label>Max Bet:</label>
                            <span>$${analytics.gameplay.max_bet}</span>
                        </div>
                        <div class="gameplay-item">
                            <label>Bonus Features:</label>
                            <span>${analytics.gameplay.bonus_features.join(', ')}</span>
                        </div>
                    </div>
                </div>

                <div class="analytics-section">
                    <h4>Performance Metrics</h4>
                    <div class="performance-grid">
                        <div class="performance-item">
                            <label>Popularity Score:</label>
                            <span class="score">${analytics.performance.popularity_score}/100</span>
                        </div>
                        <div class="performance-item">
                            <label>Player Rating:</label>
                            <span class="rating">${analytics.performance.player_rating}/10</span>
                        </div>
                        <div class="performance-item">
                            <label>Traffic Rank:</label>
                            <span class="rank">${analytics.performance.traffic_rank}</span>
                        </div>
                    </div>
                </div>
            </div>`;
    }

    redirectToRealMoney(slotId) {
        // Track real money click
        this.trackEvent('real_money_clicked', { slot_id: slotId });
        
        // Redirect to casino selection page
        window.open('/casinos?game=' + slotId, '_blank');
    }

    closeDemoModal() {
        const modal = document.getElementById('demo-modal');
        const iframe = document.getElementById('demo-frame');
        
        if (modal) {
            modal.classList.remove('active');
            document.body.style.overflow = '';
        }
        
        if (iframe) {
            iframe.src = '';
        }
    }

    closeAnalyticsModal() {
        const modal = document.getElementById('analytics-modal');
        
        if (modal) {
            modal.classList.remove('active');
            document.body.style.overflow = '';
        }
    }

    closeModals() {
        this.closeDemoModal();
        this.closeAnalyticsModal();
    }

    loadSlotImages() {
        const images = document.querySelectorAll('.slot-card img[loading="lazy"]');
        
        // Intersection Observer for lazy loading
        if ('IntersectionObserver' in window) {
            const imageObserver = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const img = entry.target;
                        img.src = img.dataset.src || img.src;
                        img.classList.remove('lazy');
                        observer.unobserve(img);
                    }
                });
            });

            images.forEach(img => imageObserver.observe(img));
        }
    }

    async loadMoreSlots() {
        this.currentPage++;
        
        try {
            this.showLoadMoreLoading();
            
            const url = new URL('/api/slots/filter', window.location.origin);
            url.searchParams.append('page', this.currentPage);
            url.searchParams.append('limit', this.slotsPerPage);
            
            // Add current filters
            Object.keys(this.currentFilters).forEach(key => {
                if (this.currentFilters[key]) {
                    url.searchParams.append(key, this.currentFilters[key]);
                }
            });

            const response = await fetch(url);
            const data = await response.json();

            if (data.success && data.slots.length > 0) {
                this.appendSlots(data.slots);
                
                if (data.slots.length < this.slotsPerPage) {
                    this.hideLoadMoreButton();
                }
            } else {
                this.hideLoadMoreButton();
            }
        } catch (error) {
            console.error('Load more error:', error);
            this.showNotification('Failed to load more slots.', 'error');
        } finally {
            this.hideLoadMoreLoading();
        }
    }

    appendSlots(slots) {
        const container = document.querySelector('.slots-container');
        if (!container) return;

        const newSlots = slots.map(slot => this.generateSlotCard(slot)).join('');
        container.insertAdjacentHTML('beforeend', newSlots);
        
        this.loadSlotImages();
    }

    showLoading() {
        const container = document.querySelector('.slots-container');
        if (container) {
            container.innerHTML = '<div class="loading-spinner">Loading slots...</div>';
        }
    }

    hideLoading() {
        // Loading is hidden when content is updated
    }

    showLoadMoreLoading() {
        if (this.loadMoreBtn) {
            this.loadMoreBtn.textContent = 'Loading...';
            this.loadMoreBtn.disabled = true;
        }
    }

    hideLoadMoreLoading() {
        if (this.loadMoreBtn) {
            this.loadMoreBtn.textContent = 'Load More Slots';
            this.loadMoreBtn.disabled = false;
        }
    }

    hideLoadMoreButton() {
        if (this.loadMoreBtn) {
            this.loadMoreBtn.style.display = 'none';
        }
    }

    updateFiltersInfo(data) {
        const count = data.count || 0;
        const slotsCount = document.querySelector('.slots-count');
        
        if (slotsCount) {
            slotsCount.textContent = `Showing ${count} slots${Object.keys(this.currentFilters).length > 0 ? ' (filtered)' : ''}`;
        }
    }

    showNotification(message, type = 'info') {
        // Create notification element
        const notification = document.createElement('div');
        notification.className = `notification notification-${type}`;
        notification.textContent = message;
        
        // Style the notification
        Object.assign(notification.style, {
            position: 'fixed',
            top: '20px',
            right: '20px',
            background: type === 'error' ? '#dc3545' : type === 'warning' ? '#ffc107' : '#007bff',
            color: 'white',
            padding: '15px 20px',
            borderRadius: '6px',
            zIndex: '10000',
            boxShadow: '0 4px 20px rgba(0, 0, 0, 0.2)',
            transition: 'all 0.3s ease'
        });
        
        document.body.appendChild(notification);
        
        // Auto remove after 3 seconds
        setTimeout(() => {
            notification.style.opacity = '0';
            setTimeout(() => {
                document.body.removeChild(notification);
            }, 300);
        }, 3000);
    }

    trackEvent(eventName, data = {}) {
        // Analytics tracking
        if (typeof gtag !== 'undefined') {
            gtag('event', eventName, data);
        }
        
        console.log('Event tracked:', eventName, data);
    }

    formatNumber(num) {
        if (num >= 1000000) {
            return (num / 1000000).toFixed(1) + 'M';
        } else if (num >= 1000) {
            return (num / 1000).toFixed(1) + 'K';
        }
        return num.toLocaleString();
    }
}

// Initialize when DOM is ready
document.addEventListener('DOMContentLoaded', function() {
    if (document.querySelector('.popular-slots-detailed')) {
        window.slotsManager = new SlotsManager();
    }
});
