# PRD #20: Problem Gambling Resources Section - 2025

## **📋 OVERVIEW**
Create a comprehensive Problem Gambling Resources section that provides Canadian players with immediate access to help, support organizations, and self-exclusion tools. This demonstrates our commitment to responsible gambling and regulatory compliance while building trust through player protection initiatives.

## **🎯 OBJECTIVES**
- **Primary Goal:** Provide immediate access to Canadian gambling addiction resources
- **Compliance Target:** Meet regulatory requirements for responsible gambling information
- **User Safety:** Offer comprehensive support for players at risk
- **Trust Building:** Demonstrate commitment to player welfare and responsible gambling
- **Legal Compliance:** Align with iGaming Ontario and provincial gambling regulations

## **👥 USER STORIES**

### **🆘 Player Seeking Help:**
```gherkin
GIVEN I recognize I have a gambling problem
WHEN I visit the problem gambling resources section
THEN I should see immediate crisis hotline numbers
AND I should see Canadian-specific support organizations
AND I should see self-exclusion tools and instructions
AND I should see assessment questionnaires to evaluate my situation
AND I should see treatment options and professional counseling resources
```

### **👨‍👩‍👧‍👦 Family Member or Friend:**
```gherkin
GIVEN I'm concerned about someone's gambling
WHEN I explore the resources section
THEN I should see guidance for family and friends
AND I should see how to approach someone with a gambling problem
AND I should see support groups for affected families
AND I should see warning signs and assessment tools
```

### **🔒 Player Using Prevention Tools:**
```gherkin
GIVEN I want to gamble responsibly
WHEN I access responsible gambling tools
THEN I should see deposit limit instructions
AND I should see time limit setting options
AND I should see reality check reminders
AND I should see self-assessment questionnaires
AND I should see cooling-off period options
```

## **🔧 TECHNICAL REQUIREMENTS**

### **Frontend Components:**
```php
// Problem gambling resources data structure
class ProblemGamblingService {
    public function getGamblingResources() {
        return [
            'crisis_resources' => [
                'national_hotlines' => [
                    'crisis_services_canada' => [
                        'name' => 'Crisis Services Canada',
                        'phone' => '1-833-456-4566',
                        'website' => 'https://crisisservicescanada.ca',
                        'availability' => '24/7',
                        'languages' => ['English', 'French'],
                        'description' => 'Free, confidential support for anyone in Canada experiencing thoughts of suicide or emotional distress',
                        'text_option' => '45645'
                    ],
                    'gambling_help_online' => [
                        'name' => 'Gambling Help Online',
                        'phone' => '1-888-391-1111',
                        'website' => 'https://www.gamblinghelplineonline.ca',
                        'availability' => '24/7',
                        'languages' => ['English', 'French'],
                        'description' => 'National gambling problem helpline with live chat support',
                        'chat_available' => true
                    ]
                ],
                'provincial_resources' => [
                    'ontario' => [
                        'name' => 'ConnexOntario',
                        'phone' => '1-866-531-2600',
                        'website' => 'https://www.connexontario.ca',
                        'services' => ['Mental health', 'Addiction', 'Problem gambling'],
                        'specialized_gambling_line' => '1-888-230-3505'
                    ],
                    'british_columbia' => [
                        'name' => 'BC Problem Gambling Help Line',
                        'phone' => '1-888-795-6111',
                        'website' => 'https://www.bcresponsiblegambling.ca',
                        'services' => ['Counseling referrals', 'Support groups', 'Self-exclusion']
                    ],
                    'alberta' => [
                        'name' => 'Alberta Health Services - Addiction Helpline',
                        'phone' => '1-866-332-2322',
                        'website' => 'https://www.albertahealthservices.ca',
                        'services' => ['24/7 support', 'Treatment referrals', 'Family support']
                    ],
                    'quebec' => [
                        'name' => 'Jeu: Aide et Référence',
                        'phone' => '1-800-461-0140',
                        'website' => 'https://www.jeuaidetreferance.qc.ca',
                        'languages' => ['French', 'English'],
                        'services' => ['Gambling help', 'Support groups', 'Prevention']
                    ],
                    'manitoba' => [
                        'name' => 'Addictions Foundation of Manitoba',
                        'phone' => '1-855-662-6605',
                        'website' => 'https://afm.mb.ca',
                        'services' => ['Problem gambling counseling', 'Family support', 'Prevention programs']
                    ],
                    'saskatchewan' => [
                        'name' => 'HealthLine 811',
                        'phone' => '811',
                        'website' => 'https://www.saskatchewan.ca',
                        'services' => ['Health information', 'Addiction resources', 'Counseling referrals']
                    ],
                    'nova_scotia' => [
                        'name' => 'Problem Gambling Services',
                        'phone' => '1-888-347-8888',
                        'website' => 'https://nsgamingfoundation.org',
                        'services' => ['Counseling', 'Support groups', 'Educational resources']
                    ],
                    'new_brunswick' => [
                        'name' => 'Télé-Soins 811',
                        'phone' => '811',
                        'website' => 'https://www.gnb.ca',
                        'services' => ['Health advice', 'Addiction support', 'Mental health resources']
                    ],
                    'newfoundland' => [
                        'name' => 'HealthLine 811',
                        'phone' => '811',
                        'website' => 'https://www.health.gov.nl.ca',
                        'services' => ['24/7 health support', 'Addiction counseling', 'Mental health']
                    ],
                    'pei' => [
                        'name' => 'HealthPEI Mental Health and Addictions',
                        'phone' => '1-855-225-2272',
                        'website' => 'https://www.princeedwardisland.ca',
                        'services' => ['Mental health support', 'Addiction services', 'Crisis intervention']
                    ]
                ]
            ],
            'support_organizations' => [
                'gamblers_anonymous' => [
                    'name' => 'Gamblers Anonymous',
                    'phone' => '(909) 931-9056',
                    'website' => 'https://www.gamblersanonymous.org',
                    'type' => '12-step program',
                    'meeting_format' => ['In-person', 'Online', 'Phone'],
                    'description' => 'Fellowship of men and women who share experience, strength and hope to recover from gambling addiction',
                    'canadian_chapters' => true
                ],
                'camh' => [
                    'name' => 'Centre for Addiction and Mental Health (CAMH)',
                    'phone' => '+1 (800) 463-2338',
                    'website' => 'https://www.camh.ca',
                    'location' => 'Toronto, Ontario',
                    'services' => ['Clinical treatment', 'Research', 'Education', 'Policy development'],
                    'specialized_programs' => ['Problem gambling clinic', 'Family support', 'Prevention initiatives']
                ],
                'responsible_gambling_council' => [
                    'name' => 'Responsible Gambling Council (RGC)',
                    'phone' => '+1 (416) 499-8800',
                    'website' => 'https://www.responsiblegambling.org',
                    'location' => 'Toronto, Ontario',
                    'services' => ['Research', 'Education', 'Treatment referrals', 'Policy advocacy'],
                    'programs' => ['GameSense', 'My PlaySmart', 'RG Check certification']
                ],
                'ncpg' => [
                    'name' => 'National Council on Problem Gambling',
                    'phone' => '1-800-522-4700',
                    'website' => 'https://www.ncpgambling.org',
                    'services' => ['24/7 helpline', 'Treatment referrals', 'Educational resources'],
                    'canadian_coverage' => true
                ]
            ],
            'self_assessment_tools' => [
                'brief_questionnaire' => [
                    'name' => 'Problem Gambling Severity Index (PGSI)',
                    'questions' => [
                        'Have you bet more than you could really afford to lose?',
                        'Have you needed to gamble with larger amounts of money to get the same feeling of excitement?',
                        'When you gambled, did you go back another day to try to win back the money you lost?',
                        'Have you borrowed money or sold anything to get money to gamble?',
                        'Have you felt that you might have a problem with gambling?',
                        'Have people criticized your betting or told you that you had a gambling problem?',
                        'Have you felt guilty about the way you gamble or what happens when you gamble?',
                        'Has your gambling caused you any health problems, including stress or anxiety?',
                        'Has your gambling caused any financial problems for you or your household?'
                    ],
                    'scoring' => [
                        'never' => 0,
                        'sometimes' => 1,
                        'most_of_the_time' => 2,
                        'almost_always' => 3
                    ],
                    'interpretation' => [
                        '0' => 'No problem',
                        '1-2' => 'Low risk',
                        '3-7' => 'Moderate risk',
                        '8+' => 'High risk - seek professional help'
                    ]
                ],
                'warning_signs' => [
                    'behavioral' => [
                        'Spending more time and money gambling than intended',
                        'Lying about gambling activities or losses',
                        'Borrowing money to gamble or pay gambling debts',
                        'Neglecting work, family, or personal responsibilities',
                        'Chasing losses with bigger bets',
                        'Unable to stop gambling despite wanting to'
                    ],
                    'emotional' => [
                        'Feeling restless or irritable when trying to cut down',
                        'Gambling to escape problems or negative emotions',
                        'Feeling guilty, anxious, or depressed about gambling',
                        'Mood swings related to wins and losses',
                        'Loss of interest in other activities'
                    ],
                    'physical' => [
                        'Sleep problems or insomnia',
                        'Changes in appetite',
                        'Headaches or stomach problems from stress',
                        'Fatigue from long gambling sessions'
                    ],
                    'financial' => [
                        'Borrowing money frequently',
                        'Maxing out credit cards',
                        'Selling personal belongings',
                        'Unable to pay bills or meet financial obligations',
                        'Secretive about money or financial accounts'
                    ]
                ]
            ],
            'responsible_gambling_tools' => [
                'deposit_limits' => [
                    'daily_limits' => 'Set maximum daily deposit amounts',
                    'weekly_limits' => 'Set maximum weekly deposit amounts',
                    'monthly_limits' => 'Set maximum monthly deposit amounts',
                    'how_to_set' => 'Available in account settings of licensed casinos',
                    'cooling_period' => '24-hour delay for limit increases'
                ],
                'time_limits' => [
                    'session_limits' => 'Set maximum playing time per session',
                    'daily_limits' => 'Set maximum playing time per day',
                    'reality_check' => 'Regular reminders of time spent gambling',
                    'automatic_logout' => 'Forced logout when limits are reached'
                ],
                'self_exclusion' => [
                    'temporary_exclusion' => [
                        'duration' => '24 hours to 6 months',
                        'process' => 'Immediate activation through casino account',
                        'features' => 'Complete account suspension, no promotional materials'
                    ],
                    'permanent_exclusion' => [
                        'duration' => 'Minimum 5 years or permanent',
                        'process' => 'Formal application required',
                        'features' => 'Complete ban from all associated properties'
                    ],
                    'third_party_exclusion' => [
                        'gamstop' => 'UK-based self-exclusion service',
                        'gamban' => 'Software blocking gambling websites',
                        'betblocker' => 'Free gambling blocking software'
                    ]
                ]
            ],
            'treatment_options' => [
                'professional_counseling' => [
                    'cognitive_behavioral_therapy' => [
                        'description' => 'Evidence-based therapy addressing thought patterns and behaviors',
                        'effectiveness' => 'High success rate for gambling addiction',
                        'availability' => 'Covered by most Canadian health plans'
                    ],
                    'individual_therapy' => [
                        'description' => 'One-on-one counseling with addiction specialists',
                        'focus' => 'Personal triggers, coping strategies, relapse prevention'
                    ],
                    'group_therapy' => [
                        'description' => 'Support groups led by professional counselors',
                        'benefits' => 'Peer support, shared experiences, accountability'
                    ]
                ],
                'support_groups' => [
                    'gamblers_anonymous' => [
                        'format' => '12-step program',
                        'cost' => 'Free',
                        'availability' => 'Multiple meetings per week in major cities'
                    ],
                    'gam_anon' => [
                        'focus' => 'Family and friends of problem gamblers',
                        'format' => 'Support group meetings',
                        'resources' => 'Educational materials and coping strategies'
                    ]
                ],
                'online_resources' => [
                    'self_help_programs' => [
                        'my_playsmart' => 'Ontario Lottery and Gaming educational program',
                        'gamesense' => 'British Columbia responsible gambling program',
                        'know_your_limit' => 'Alberta gaming awareness initiative'
                    ],
                    'mobile_apps' => [
                        'quit_gambling' => 'Habit tracking and motivation app',
                        'gambling_therapy' => 'Online counseling platform',
                        'bet_blocker' => 'Website and app blocking tool'
                    ]
                ]
            ],
            'family_support' => [
                'for_family_members' => [
                    'understanding_addiction' => 'Educational resources about gambling addiction',
                    'communication_strategies' => 'How to talk to someone about their gambling',
                    'setting_boundaries' => 'Protecting yourself and your family financially',
                    'enabling_behaviors' => 'Recognizing and avoiding behaviors that enable gambling'
                ],
                'support_services' => [
                    'family_counseling' => 'Professional counseling for affected families',
                    'financial_counseling' => 'Help with debt management and financial recovery',
                    'legal_assistance' => 'Information about legal options and protections'
                ]
            ]
        ];
    }
    
    public function getEmergencyContacts() {
        return [
            'crisis_lines' => [
                'immediate_help' => '1-833-456-4566',
                'gambling_specific' => '1-888-391-1111',
                'text_support' => '45645'
            ],
            'emergency_services' => '911'
        ];
    }
}
```

### **Component Structure:**
```php
// ProblemGamblingController.php
class ProblemGamblingController {
    public function index() {
        $resources = $this->gamblingService->getGamblingResources();
        $emergencyContacts = $this->gamblingService->getEmergencyContacts();
        return $this->render('problem-gambling/index', compact('resources', 'emergencyContacts'));
    }
    
    public function selfAssessment() {
        $assessment = $this->gamblingService->getGamblingResources()['self_assessment_tools'];
        return $this->render('problem-gambling/assessment', compact('assessment'));
    }
    
    public function provincialResources($province) {
        $resources = $this->gamblingService->getGamblingResources();
        $provincialData = $resources['crisis_resources']['provincial_resources'][$province] ?? null;
        
        if (!$provincialData) {
            return $this->render('errors/404');
        }
        
        return $this->render('problem-gambling/provincial', compact('provincialData', 'province'));
    }
}

// Problem gambling resources template
<div class="problem-gambling-section">
    <div class="emergency-banner">
        <div class="emergency-content">
            <h2>Need Immediate Help?</h2>
            <div class="crisis-contacts">
                <div class="contact-item primary">
                    <span class="contact-type">24/7 Crisis Line</span>
                    <a href="tel:1-833-456-4566" class="contact-number">1-833-456-4566</a>
                    <span class="contact-desc">Crisis Services Canada</span>
                </div>
                <div class="contact-item">
                    <span class="contact-type">Gambling Help</span>
                    <a href="tel:1-888-391-1111" class="contact-number">1-888-391-1111</a>
                    <span class="contact-desc">24/7 Support & Live Chat</span>
                </div>
                <div class="contact-item">
                    <span class="contact-type">Text Support</span>
                    <a href="sms:45645" class="contact-number">45645</a>
                    <span class="contact-desc">Text for help</span>
                </div>
            </div>
        </div>
    </div>
</div>
```

### **CSS Styling:**
```css
/* problem-gambling.css */
.problem-gambling-section {
    padding: 0;
    background: #f8f9fa;
}

.emergency-banner {
    background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
    color: white;
    padding: 40px 0;
    text-align: center;
    position: sticky;
    top: 0;
    z-index: 100;
    box-shadow: 0 2px 10px rgba(220, 53, 69, 0.3);
}

.emergency-content h2 {
    font-size: 2rem;
    margin-bottom: 25px;
    font-weight: 700;
}

.crisis-contacts {
    display: flex;
    justify-content: center;
    gap: 30px;
    flex-wrap: wrap;
    max-width: 1000px;
    margin: 0 auto;
}

.contact-item {
    background: rgba(255, 255, 255, 0.15);
    padding: 20px;
    border-radius: 12px;
    text-align: center;
    min-width: 200px;
    backdrop-filter: blur(10px);
    transition: all 0.3s ease;
}

.contact-item:hover {
    background: rgba(255, 255, 255, 0.25);
    transform: translateY(-3px);
}

.contact-item.primary {
    background: rgba(255, 255, 255, 0.25);
    border: 2px solid rgba(255, 255, 255, 0.5);
}

.contact-type {
    display: block;
    font-size: 0.9rem;
    opacity: 0.9;
    margin-bottom: 5px;
    font-weight: 500;
}

.contact-number {
    display: block;
    font-size: 1.5rem;
    font-weight: 700;
    color: white;
    text-decoration: none;
    margin-bottom: 5px;
    letter-spacing: 0.5px;
}

.contact-number:hover {
    color: #fff;
    text-decoration: underline;
}

.contact-desc {
    font-size: 0.8rem;
    opacity: 0.8;
    display: block;
}

.resources-content {
    max-width: 1200px;
    margin: 0 auto;
    padding: 60px 20px;
}

.section-header {
    text-align: center;
    margin-bottom: 50px;
}

.section-title {
    font-size: 2.5rem;
    color: #1a365d;
    margin-bottom: 15px;
    font-weight: 700;
}

.section-subtitle {
    font-size: 1.2rem;
    color: #4a5568;
    max-width: 800px;
    margin: 0 auto;
    line-height: 1.6;
}

.resources-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
    gap: 30px;
    margin-bottom: 60px;
}

.resource-category {
    background: white;
    border-radius: 12px;
    padding: 30px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
}

.resource-category:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 15px rgba(0, 0, 0, 0.15);
}

.category-header {
    display: flex;
    align-items: center;
    margin-bottom: 20px;
}

.category-icon {
    font-size: 2rem;
    margin-right: 15px;
    color: #dc3545;
}

.category-title {
    font-size: 1.5rem;
    color: #2d3748;
    font-weight: 600;
    margin: 0;
}

.resource-list {
    space-y: 15px;
}

.resource-item {
    padding: 15px;
    background: #f8f9fa;
    border-radius: 8px;
    border-left: 4px solid #dc3545;
    margin-bottom: 15px;
}

.resource-name {
    font-size: 1.1rem;
    font-weight: 600;
    color: #2d3748;
    margin-bottom: 5px;
}

.resource-phone {
    font-size: 1.2rem;
    font-weight: 700;
    color: #dc3545;
    text-decoration: none;
    display: block;
    margin-bottom: 5px;
}

.resource-phone:hover {
    color: #c82333;
    text-decoration: underline;
}

.resource-details {
    font-size: 0.9rem;
    color: #4a5568;
    line-height: 1.5;
}

.resource-website {
    color: #3182ce;
    text-decoration: none;
    font-weight: 500;
}

.resource-website:hover {
    text-decoration: underline;
}

.self-assessment-section {
    background: white;
    border-radius: 12px;
    padding: 40px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    margin-bottom: 40px;
}

.assessment-intro {
    text-align: center;
    margin-bottom: 40px;
}

.assessment-disclaimer {
    background: #fff3cd;
    border: 1px solid #ffeaa7;
    border-radius: 8px;
    padding: 20px;
    margin-bottom: 30px;
    color: #856404;
}

.questionnaire {
    max-width: 800px;
    margin: 0 auto;
}

.question-item {
    margin-bottom: 25px;
    padding: 20px;
    background: #f8f9fa;
    border-radius: 8px;
}

.question-text {
    font-size: 1.1rem;
    font-weight: 500;
    color: #2d3748;
    margin-bottom: 15px;
}

.answer-options {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
    gap: 10px;
}

.answer-option {
    display: flex;
    align-items: center;
    padding: 10px;
    background: white;
    border: 2px solid #e2e8f0;
    border-radius: 6px;
    cursor: pointer;
    transition: all 0.3s ease;
}

.answer-option:hover {
    border-color: #3182ce;
    background: #ebf8ff;
}

.answer-option input[type="radio"] {
    margin-right: 8px;
}

.assessment-result {
    margin-top: 30px;
    padding: 25px;
    border-radius: 12px;
    text-align: center;
    display: none;
}

.result-low-risk {
    background: #d4edda;
    border: 1px solid #c3e6cb;
    color: #155724;
}

.result-moderate-risk {
    background: #fff3cd;
    border: 1px solid #ffeaa7;
    color: #856404;
}

.result-high-risk {
    background: #f8d7da;
    border: 1px solid #f5c6cb;
    color: #721c24;
}

.warning-signs-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 25px;
}

.warning-category {
    background: white;
    border-radius: 12px;
    padding: 25px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.warning-category h4 {
    font-size: 1.3rem;
    color: #2d3748;
    margin-bottom: 15px;
    font-weight: 600;
}

.warning-list {
    list-style: none;
    padding: 0;
}

.warning-list li {
    padding: 8px 0;
    border-bottom: 1px solid #e2e8f0;
    color: #4a5568;
    line-height: 1.5;
}

.warning-list li:last-child {
    border-bottom: none;
}

.warning-list li:before {
    content: "⚠️";
    margin-right: 10px;
}

.tools-section {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-radius: 12px;
    padding: 40px;
    margin-bottom: 40px;
}

.tools-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 25px;
    margin-top: 30px;
}

.tool-card {
    background: rgba(255, 255, 255, 0.1);
    border-radius: 12px;
    padding: 25px;
    backdrop-filter: blur(10px);
    transition: all 0.3s ease;
}

.tool-card:hover {
    background: rgba(255, 255, 255, 0.2);
    transform: translateY(-3px);
}

.tool-icon {
    font-size: 2.5rem;
    margin-bottom: 15px;
    display: block;
}

.tool-title {
    font-size: 1.3rem;
    font-weight: 600;
    margin-bottom: 10px;
}

.tool-description {
    font-size: 1rem;
    opacity: 0.9;
    line-height: 1.6;
}

.provincial-resources {
    background: white;
    border-radius: 12px;
    padding: 40px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.provinces-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
    margin-top: 30px;
}

.province-card {
    background: #f8f9fa;
    border-radius: 8px;
    padding: 20px;
    text-align: center;
    transition: all 0.3s ease;
    cursor: pointer;
}

.province-card:hover {
    background: white;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    transform: translateY(-2px);
}

.province-name {
    font-size: 1.1rem;
    font-weight: 600;
    color: #2d3748;
    margin-bottom: 10px;
}

.province-contact {
    color: #dc3545;
    font-weight: 500;
    text-decoration: none;
}

.treatment-options {
    background: white;
    border-radius: 12px;
    padding: 40px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    margin-bottom: 40px;
}

.treatment-categories {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
    gap: 30px;
    margin-top: 30px;
}

.treatment-category {
    background: #f8f9fa;
    border-radius: 12px;
    padding: 25px;
}

.treatment-title {
    font-size: 1.4rem;
    color: #2d3748;
    font-weight: 600;
    margin-bottom: 20px;
}

.treatment-options-list {
    space-y: 15px;
}

.treatment-option {
    padding: 15px;
    background: white;
    border-radius: 8px;
    border-left: 4px solid #38a169;
    margin-bottom: 15px;
}

.option-name {
    font-size: 1.1rem;
    font-weight: 600;
    color: #2d3748;
    margin-bottom: 5px;
}

.option-description {
    color: #4a5568;
    line-height: 1.5;
    font-size: 0.95rem;
}

/* Responsive Design */
@media (max-width: 768px) {
    .crisis-contacts {
        flex-direction: column;
        gap: 15px;
    }
    
    .contact-item {
        min-width: auto;
    }
    
    .resources-grid {
        grid-template-columns: 1fr;
        gap: 20px;
    }
    
    .answer-options {
        grid-template-columns: 1fr;
    }
    
    .warning-signs-grid {
        grid-template-columns: 1fr;
    }
    
    .tools-grid {
        grid-template-columns: 1fr;
    }
    
    .provinces-grid {
        grid-template-columns: repeat(2, 1fr);
    }
    
    .treatment-categories {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 480px) {
    .emergency-banner {
        padding: 25px 15px;
    }
    
    .emergency-content h2 {
        font-size: 1.5rem;
    }
    
    .contact-number {
        font-size: 1.3rem;
    }
    
    .resources-content {
        padding: 40px 15px;
    }
    
    .resource-category,
    .self-assessment-section,
    .tools-section,
    .provincial-resources,
    .treatment-options {
        margin: 0 15px 30px;
        padding: 20px;
    }
    
    .provinces-grid {
        grid-template-columns: 1fr;
    }
}
```

## **📊 ACCEPTANCE CRITERIA**

### **✅ Emergency Resources:**
```gherkin
GIVEN a user needs immediate help
WHEN they visit the problem gambling resources page
THEN they should see prominent emergency contact information:
  - Crisis Services Canada: 1-833-456-4566 (24/7)
  - Gambling Help Online: 1-888-391-1111 (24/7)
  - Text support: 45645
AND emergency contacts should be clickable for immediate calling/texting
AND the emergency section should be sticky at the top of the page
```

### **✅ Provincial Resources:**
```gherkin
GIVEN a user wants local support
WHEN they explore provincial resources
THEN they should see dedicated resources for all 10 provinces:
  - Ontario: ConnexOntario (1-866-531-2600)
  - British Columbia: BC Problem Gambling Help Line (1-888-795-6111)
  - Alberta: Alberta Health Services (1-866-332-2322)
  - Quebec: Jeu: Aide et Référence (1-800-461-0140)
  - Manitoba: Addictions Foundation (1-855-662-6605)
  - And 5 additional provinces with specific contact information
AND each province should show specialized services and languages available
```

### **✅ Self-Assessment Tools:**
```gherkin
GIVEN a user wants to assess their gambling behavior
WHEN they complete the self-assessment questionnaire
THEN they should see the Problem Gambling Severity Index (PGSI) with 9 questions
AND scoring should provide interpretation:
  - 0 points: No problem
  - 1-2 points: Low risk
  - 3-7 points: Moderate risk
  - 8+ points: High risk - seek professional help
AND warning signs should be categorized: behavioral, emotional, physical, financial
```

## **🎨 DESIGN SPECIFICATIONS**

### **Visual Design:**
- **Color Scheme:** Emergency red for crisis contacts, calming blues for support information
- **Typography:** Clear, accessible fonts with high contrast for emergency information
- **Icons:** Crisis support and help-related icons emphasizing immediate assistance
- **Layout:** Emergency banner at top, organized resource categories below
- **Accessibility:** High contrast colors, large clickable phone numbers, clear navigation

### **Interactive Elements:**
- **Emergency Contacts:** Direct click-to-call and text functionality
- **Self-Assessment:** Interactive questionnaire with real-time scoring
- **Provincial Filters:** Easy navigation to local resources
- **Resource Cards:** Hover effects and clear contact information
- **Mobile Optimization:** Touch-friendly emergency contacts and easy scrolling

## **🚀 IMPLEMENTATION PHASES**

### **Phase 1: Emergency Infrastructure (Day 1)**
- Create ProblemGamblingService with emergency contacts
- Build emergency banner with crisis hotlines
- Implement click-to-call and text functionality
- Add provincial resource database

### **Phase 2: Assessment Tools (Day 2)**
- Create self-assessment questionnaire with PGSI
- Implement real-time scoring and interpretation
- Add warning signs categorization
- Build interactive questionnaire interface

### **Phase 3: Support Resources (Day 3)**
- Add comprehensive support organization information
- Create treatment options and professional resources
- Implement family support and educational resources
- Build responsible gambling tools section

### **Phase 4: Integration & Compliance (Day 4)**
- Integrate resources into main navigation
- Add responsible gambling footer links
- Implement regulatory compliance features
- Performance optimization and accessibility enhancements

## **🧪 TESTING COMMANDS**

### **Functional Testing:**
```bash
# Test problem gambling resources loading
curl https://bestcasinoportal.com/api/problem-gambling-resources

# Test resource pages
curl https://bestcasinoportal.com/problem-gambling
curl https://bestcasinoportal.com/problem-gambling/assessment
curl https://bestcasinoportal.com/problem-gambling/ontario

# Test emergency contacts accessibility
curl https://bestcasinoportal.com/api/emergency-contacts
```

### **Compliance Testing:**
```bash
# Test responsible gambling footer links
curl -s https://bestcasinoportal.com | grep -E 'problem.gambling|responsible.gambling'

# Test emergency contact visibility
curl -s https://bestcasinoportal.com/problem-gambling | grep -E 'tel:|sms:'

# Test self-assessment functionality
curl -s https://bestcasinoportal.com/problem-gambling/assessment | grep -c 'PGSI'
```

## **📈 SUCCESS METRICS**

### **Compliance Goals:**
- **Regulatory Adherence**: 100% compliance with responsible gambling requirements
- **Resource Accessibility**: All emergency contacts clickable and functional
- **Provincial Coverage**: Complete coverage of all Canadian provinces
- **Assessment Tools**: Validated PGSI questionnaire with proper scoring

### **User Support Targets:**
- **Emergency Access**: Crisis contacts accessible within 3 seconds
- **Resource Discovery**: Provincial resources findable within 2 clicks
- **Assessment Completion**: Self-assessment completable in under 5 minutes
- **Mobile Accessibility**: Full functionality on mobile devices

## **🔗 INTEGRATION POINTS**

### **Site-wide Integration:**
- Add "Responsible Gambling" link to main navigation
- Include problem gambling resources in footer
- Cross-link from all gambling-related content

### **Casino Review Integration:**
- Link responsible gambling tools from each casino review
- Display problem gambling resources in casino terms sections
- Connect self-exclusion tools to casino account settings

### **Trust Building Integration:**
- Connect to regulatory compliance sections
- Integrate with legal status and regulation information
- Build credibility through comprehensive player protection

---

**🎯 DELIVERABLES:**
1. ✅ ProblemGamblingService with emergency contacts and provincial resources
2. ✅ Emergency banner with crisis hotlines and click-to-call functionality
3. ✅ Self-assessment questionnaire with PGSI scoring and interpretation
4. ✅ Comprehensive support organization database with Canadian coverage
5. ✅ Warning signs categorization and responsible gambling tools
6. ✅ Treatment options and professional counseling resources
7. ✅ Family support information and educational materials
8. ✅ Mobile-responsive problem gambling resource interface

**⏰ TIMELINE:** 4 days
**👥 STAKEHOLDERS:** Legal/Compliance team, Player protection, Customer support
**🔄 DEPENDENCIES:** Provincial resource verification, Emergency contact validation, Regulatory compliance requirements
