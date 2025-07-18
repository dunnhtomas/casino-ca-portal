<?php
/**
 * FAQ Section View - Homepage Integration
 * 
 * Displays featured FAQs on the homepage with search functionality
 * and links to the full FAQ page.
 * 
 * @var array $featuredFAQs Featured FAQ data
 * @var array $statistics FAQ statistics
 */
?>

<section class="faq-section" id="faq-section">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">Frequently Asked Questions</h2>
            <p class="section-subtitle">
                Get instant answers to the most common questions about online gambling in Canada
            </p>
        </div>

        <div class="faq-grid">
            <!-- Featured FAQs Column -->
            <div class="faq-featured">
                <div class="faq-list">
                    <?php foreach ($featuredFAQs as $index => $faq): ?>
                        <div class="faq-item" data-faq-id="<?= htmlspecialchars($faq['id']) ?>" data-category="<?= htmlspecialchars($faq['category']) ?>">
                            <div class="faq-question">
                                <h3><?= htmlspecialchars($faq['question']) ?></h3>
                                <button class="faq-toggle" aria-expanded="false" aria-controls="faq-answer-<?= $faq['id'] ?>">
                                    <svg class="faq-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M6 9l6 6 6-6"/>
                                    </svg>
                                </button>
                            </div>
                            <div class="faq-answer" id="faq-answer-<?= $faq['id'] ?>" aria-hidden="true">
                                <div class="faq-content">
                                    <p><?= nl2br(htmlspecialchars($faq['answer'])) ?></p>
                                    
                                    <?php if (!empty($faq['tags'])): ?>
                                        <div class="faq-tags">
                                            <?php foreach (array_slice($faq['tags'], 0, 3) as $tag): ?>
                                                <span class="faq-tag"><?= htmlspecialchars($tag) ?></span>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="faq-stats">
                    <div class="stat-item">
                        <span class="stat-number"><?= $statistics['total_faqs'] ?></span>
                        <span class="stat-label">Total Questions</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number"><?= $statistics['categories'] ?></span>
                        <span class="stat-label">Categories</span>
                    </div>
                </div>
            </div>

            <!-- FAQ Sidebar -->
            <div class="faq-sidebar">
                <div class="faq-search-box">
                    <h4>Search FAQs</h4>
                    <div class="search-container">
                        <input 
                            type="text" 
                            id="faq-search" 
                            placeholder="What would you like to know?"
                            class="search-input"
                            autocomplete="off"
                        >
                        <button class="search-button" type="button">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="11" cy="11" r="8"></circle>
                                <path d="M21 21l-4.35-4.35"></path>
                            </svg>
                        </button>
                    </div>
                    <div class="search-suggestions" id="faq-suggestions" style="display: none;">
                        <!-- Dynamic search suggestions -->
                    </div>
                </div>

                <div class="faq-categories">
                    <h4>Browse by Category</h4>
                    <div class="category-buttons">
                        <button class="category-btn active" data-category="all">All Questions</button>
                        <button class="category-btn" data-category="legal">Legal</button>
                        <button class="category-btn" data-category="safety">Safety</button>
                        <button class="category-btn" data-category="bonuses">Bonuses</button>
                        <button class="category-btn" data-category="banking">Banking</button>
                    </div>
                </div>

                <div class="faq-cta">
                    <a href="/faq" class="view-all-btn">
                        <span>View All FAQs</span>
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M5 12h14M12 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>

                <div class="quick-help">
                    <h5>Need More Help?</h5>
                    <p>Can't find what you're looking for? Our comprehensive FAQ page has over <?= $statistics['total_faqs'] ?> detailed answers.</p>
                    <div class="help-links">
                        <a href="/legal-status" class="help-link">Legal Information</a>
                        <a href="/problem-gambling" class="help-link">Responsible Gambling</a>
                        <a href="/casino-reviews" class="help-link">Casino Reviews</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mobile Search (Hidden on Desktop) -->
        <div class="faq-mobile-search">
            <input 
                type="text" 
                id="faq-mobile-search" 
                placeholder="Search FAQs..."
                class="mobile-search-input"
            >
            <a href="/faq" class="mobile-view-all">View All Questions</a>
        </div>
    </div>
</section>

<!-- FAQ Schema Markup for SEO -->
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "FAQPage",
  "mainEntity": [
    <?php foreach ($featuredFAQs as $index => $faq): ?>
    {
      "@type": "Question",
      "name": "<?= addslashes($faq['question']) ?>",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "<?= addslashes(strip_tags($faq['answer'])) ?>"
      }
    }<?= $index < count($featuredFAQs) - 1 ? ',' : '' ?>
    <?php endforeach; ?>
  ]
}
</script>

<style>
/* FAQ Section Styling */
.faq-section {
    padding: 60px 0;
    background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
    position: relative;
}

.faq-section::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 1px;
    background: linear-gradient(90deg, transparent, #cbd5e0, transparent);
}

.faq-section .container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
}

.faq-section .section-header {
    text-align: center;
    margin-bottom: 50px;
}

.faq-section .section-title {
    font-size: 2.5rem;
    font-weight: 700;
    color: #1a365d;
    margin-bottom: 15px;
    background: linear-gradient(135deg, #1a365d, #2d3748);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.faq-section .section-subtitle {
    font-size: 1.1rem;
    color: #4a5568;
    max-width: 600px;
    margin: 0 auto;
    line-height: 1.6;
}

.faq-grid {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 40px;
    align-items: start;
}

/* Featured FAQs */
.faq-featured {
    background: white;
    border-radius: 12px;
    padding: 30px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    border: 1px solid #e2e8f0;
}

.faq-item {
    border-bottom: 1px solid #e2e8f0;
    padding: 20px 0;
    transition: all 0.3s ease;
}

.faq-item:last-child {
    border-bottom: none;
}

.faq-item:hover {
    background: #f8fafc;
    margin: 0 -15px;
    padding: 20px 15px;
    border-radius: 8px;
}

.faq-question {
    display: flex;
    justify-content: space-between;
    align-items: center;
    cursor: pointer;
    user-select: none;
}

.faq-question h3 {
    font-size: 1.1rem;
    font-weight: 600;
    color: #2d3748;
    margin: 0;
    flex: 1;
    line-height: 1.5;
}

.faq-toggle {
    background: none;
    border: none;
    cursor: pointer;
    padding: 8px;
    margin-left: 15px;
    border-radius: 50%;
    transition: all 0.3s ease;
    flex-shrink: 0;
}

.faq-toggle:hover {
    background: #edf2f7;
}

.faq-icon {
    width: 20px;
    height: 20px;
    color: #4a5568;
    transition: transform 0.3s ease;
}

.faq-item.expanded .faq-icon {
    transform: rotate(180deg);
}

.faq-answer {
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.3s ease, padding 0.3s ease;
}

.faq-item.expanded .faq-answer {
    max-height: 500px;
    padding-top: 15px;
}

.faq-content p {
    color: #4a5568;
    line-height: 1.7;
    margin: 0 0 15px 0;
}

.faq-tags {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    margin-top: 15px;
}

.faq-tag {
    background: #edf2f7;
    color: #4a5568;
    padding: 4px 10px;
    border-radius: 15px;
    font-size: 0.8rem;
    font-weight: 500;
}

.faq-stats {
    display: flex;
    justify-content: space-around;
    margin-top: 30px;
    padding-top: 25px;
    border-top: 1px solid #e2e8f0;
}

.stat-item {
    text-align: center;
}

.stat-number {
    display: block;
    font-size: 2rem;
    font-weight: 700;
    color: #1a365d;
    line-height: 1;
}

.stat-label {
    font-size: 0.9rem;
    color: #4a5568;
    margin-top: 5px;
}

/* FAQ Sidebar */
.faq-search-box,
.faq-categories,
.faq-cta,
.quick-help {
    background: white;
    border-radius: 12px;
    padding: 25px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    border: 1px solid #e2e8f0;
    margin-bottom: 20px;
}

.faq-search-box h4,
.faq-categories h4,
.quick-help h5 {
    margin: 0 0 15px 0;
    color: #2d3748;
    font-weight: 600;
}

.search-container {
    position: relative;
}

.search-input {
    width: 100%;
    padding: 12px 45px 12px 15px;
    border: 2px solid #e2e8f0;
    border-radius: 8px;
    font-size: 1rem;
    transition: border-color 0.3s ease;
}

.search-input:focus {
    outline: none;
    border-color: #3182ce;
    box-shadow: 0 0 0 3px rgba(49, 130, 206, 0.1);
}

.search-button {
    position: absolute;
    right: 10px;
    top: 50%;
    transform: translateY(-50%);
    background: none;
    border: none;
    cursor: pointer;
    padding: 5px;
    color: #4a5568;
}

.search-button svg {
    width: 18px;
    height: 18px;
}

.category-buttons {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.category-btn {
    padding: 10px 15px;
    border: 2px solid #e2e8f0;
    background: white;
    border-radius: 6px;
    font-size: 0.9rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.3s ease;
    text-align: left;
}

.category-btn:hover,
.category-btn.active {
    border-color: #3182ce;
    background: #ebf8ff;
    color: #2b6cb0;
}

.view-all-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    width: 100%;
    padding: 15px;
    background: linear-gradient(135deg, #3182ce, #2b6cb0);
    color: white;
    text-decoration: none;
    border-radius: 8px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.view-all-btn:hover {
    background: linear-gradient(135deg, #2b6cb0, #2c5282);
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(49, 130, 206, 0.3);
}

.view-all-btn svg {
    width: 18px;
    height: 18px;
}

.quick-help p {
    color: #4a5568;
    line-height: 1.6;
    margin-bottom: 15px;
}

.help-links {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.help-link {
    color: #3182ce;
    text-decoration: none;
    font-size: 0.9rem;
    font-weight: 500;
    transition: color 0.3s ease;
}

.help-link:hover {
    color: #2b6cb0;
    text-decoration: underline;
}

/* Mobile Search */
.faq-mobile-search {
    display: none;
    margin-top: 40px;
    text-align: center;
}

/* Mobile Responsiveness */
@media (max-width: 768px) {
    .faq-section {
        padding: 40px 0;
    }
    
    .faq-section .section-title {
        font-size: 2rem;
    }
    
    .faq-grid {
        grid-template-columns: 1fr;
        gap: 30px;
    }
    
    .faq-sidebar {
        order: -1;
    }
    
    .faq-search-box,
    .faq-categories {
        display: none;
    }
    
    .faq-mobile-search {
        display: block;
    }
    
    .mobile-search-input {
        width: 100%;
        padding: 12px 15px;
        border: 2px solid #e2e8f0;
        border-radius: 8px;
        font-size: 1rem;
        margin-bottom: 15px;
    }
    
    .mobile-view-all {
        display: inline-block;
        padding: 12px 30px;
        background: #3182ce;
        color: white;
        text-decoration: none;
        border-radius: 6px;
        font-weight: 600;
    }
    
    .faq-question h3 {
        font-size: 1rem;
    }
    
    .faq-featured {
        padding: 20px;
    }
    
    .stat-number {
        font-size: 1.5rem;
    }
}

@media (max-width: 480px) {
    .faq-section .section-title {
        font-size: 1.75rem;
    }
    
    .faq-stats {
        flex-direction: column;
        gap: 15px;
    }
    
    .category-buttons {
        grid-template-columns: 1fr 1fr;
        gap: 10px;
    }
}
</style>
