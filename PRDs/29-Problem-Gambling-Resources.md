# PRD #29: Problem Gambling Resources Section

## Executive Summary
Create a comprehensive Problem Gambling Resources section that provides Canadian players with immediate access to support services, self-assessment tools, and responsible gambling information. This section demonstrates our commitment to player safety and regulatory compliance while building trust through transparency.

## Business Context

### User Stories
- **As a concerned player**, I want to access gambling addiction resources quickly so I can get help when needed
- **As a family member**, I want to understand warning signs and support options for loved ones with gambling problems
- **As a responsible casino operator**, I want to provide comprehensive resources to meet regulatory requirements
- **As a Canadian resident**, I want province-specific gambling support services and helplines

### Value Proposition
- **Player Safety First**: Immediate access to critical support resources
- **Regulatory Compliance**: Meet Canadian responsible gambling requirements
- **Trust Building**: Demonstrate commitment to player welfare
- **SEO Benefits**: Rank for responsible gambling keywords
- **Social Responsibility**: Contribute to gambling harm reduction

## Technical Requirements

### Core Features
1. **Crisis Support Section**: Immediate help resources with 24/7 hotlines
2. **Self-Assessment Tools**: Interactive questionnaires to identify problem gambling
3. **Provincial Resources**: Canada-specific support services by province
4. **Support Organizations**: Links to major gambling addiction organizations
5. **Family Support**: Resources for friends and family members
6. **Responsible Gambling Tools**: Setting limits, self-exclusion information

### API Endpoints
- `GET /api/problem-gambling` - Complete resources data
- `GET /api/problem-gambling/crisis` - Crisis support information
- `GET /api/problem-gambling/provincial` - Provincial support services
- `GET /api/problem-gambling/assessment` - Self-assessment tools
- `GET /api/problem-gambling/organizations` - Support organizations list

### Database Schema
```sql
-- Problem Gambling Resources
support_organizations (
    id INT PRIMARY KEY,
    name VARCHAR(255),
    type ENUM('crisis', 'counseling', 'provincial', 'national'),
    phone VARCHAR(20),
    website VARCHAR(255),
    provinces JSON,
    services JSON,
    availability VARCHAR(100),
    language_support JSON
);

self_assessment_questions (
    id INT PRIMARY KEY,
    question_text TEXT,
    question_type ENUM('yes_no', 'scale', 'multiple_choice'),
    scoring_weight INT,
    category VARCHAR(100)
);

provincial_resources (
    id INT PRIMARY KEY,
    province_code CHAR(2),
    province_name VARCHAR(100),
    primary_helpline VARCHAR(20),
    website VARCHAR(255),
    local_services JSON,
    exclusion_programs JSON
);
```

## UI/UX Requirements

### Design Specifications
- **Color Scheme**: Calming blues and greens, avoid red (triggering)
- **Typography**: Clear, readable fonts with good contrast
- **Layout**: Clean, uncluttered design focused on accessibility
- **Icons**: Supportive, non-judgmental iconography
- **Mobile**: Fully responsive for crisis situations

### Component Structure
```
ProblemGamblingSection/
├── CrisisSupport/
│   ├── EmergencyHotlines
│   ├── ImmediateHelp
│   └── CrisisText
├── SelfAssessment/
│   ├── QuestionnaireForm
│   ├── ScoringResults
│   └── NextSteps
├── ProvincialResources/
│   ├── ProvinceSelector
│   ├── LocalServices
│   └── ExclusionPrograms
└── SupportOrganizations/
    ├── NationalServices
    ├── OnlineSupport
    └── FamilyResources
```

### User Experience Flow
1. **Immediate Crisis Support** - Prominent placement for urgent situations
2. **Self-Assessment** - Optional interactive questionnaire
3. **Local Resources** - Province-specific support services
4. **Educational Content** - Understanding problem gambling
5. **Family Support** - Resources for concerned relatives
6. **Follow-up Actions** - Next steps and ongoing support

## Content Strategy

### Crisis Support Information
- **National Problem Gambling Helpline**: 1-888-230-3505
- **24/7 Crisis Text Line**: Text "PROBLEMGAMBLING" to 741741
- **ConnexOntario**: 1-866-531-2600 (Ontario)
- **Gambling Help Online**: www.gamblinghelplineonline.ca
- **Problem Gambling Institute of Ontario**: www.problemgambling.ca

### Self-Assessment Questions
1. Do you think you might have a gambling problem?
2. Have you ever lied to people important to you about how much you gambled?
3. Have you ever felt the need to bet more and more money?
4. Have you ever felt restless or irritable when trying to cut down on gambling?
5. Have you gambled to escape problems or relieve feelings of helplessness?
6. After losing money gambling, have you returned to try to win back losses?
7. Have you jeopardized relationships, job, or education due to gambling?
8. Have you relied on others to provide money to relieve desperate financial situations?

### Provincial Resources
- **Ontario**: ConnexOntario, Problem Gambling Institute of Ontario
- **Quebec**: Ligne Info-Santé 811, Maison Jean Lapointe
- **British Columbia**: Problem Gambling Help Line, BCLC GameSense
- **Alberta**: Alberta Health Services, Problem Gambling Help Line
- **Manitoba**: Problem Gambling Help Line, Addictions Foundation of Manitoba
- **Saskatchewan**: Saskatchewan Health Authority
- **Nova Scotia**: Mental Health and Addictions Services
- **New Brunswick**: Horizon Health Network
- **Newfoundland and Labrador**: Eastern Health
- **Prince Edward Island**: Health PEI
- **Northwest Territories**: NWT Health and Social Services
- **Nunavut**: Government of Nunavut Health
- **Yukon**: Yukon Health and Social Services

### Support Organizations
- **Gamblers Anonymous Canada**: www.gatoronto.ca
- **National Council on Problem Gambling**: www.ncpgambling.org
- **Responsible Gambling Council**: www.responsiblegambling.org
- **Centre for Addiction and Mental Health (CAMH)**: www.camh.ca
- **Problem Gambling Institute of Ontario**: www.problemgambling.ca

## SEO Strategy

### Target Keywords
- "problem gambling help Canada"
- "gambling addiction resources"
- "responsible gambling tools"
- "gambling self-exclusion Canada"
- "problem gambling hotline"
- "gambling addiction support"
- "gambling harm reduction"

### Content Optimization
- **Meta Title**: "Problem Gambling Resources & Support - Get Help Today | Best Casino Portal"
- **Meta Description**: "Free confidential gambling addiction resources, 24/7 crisis support, self-assessment tools, and provincial helplines for Canadian players."
- **Schema Markup**: LocalBusiness, ContactPoint for helplines
- **Internal Linking**: Link from all casino/gambling content
- **External Links**: Authoritative links to official support organizations

## Technical Implementation

### Service Layer (ProblemGamblingService.php)
```php
class ProblemGamblingService {
    public function getCrisisSupport(): array;
    public function getProvincialResources(): array;
    public function getSelfAssessmentQuestions(): array;
    public function getSupportOrganizations(): array;
    public function getResourcesByProvince(string $province): array;
    public function getStatistics(): array;
}
```

### Controller (ProblemGamblingController.php)
```php
class ProblemGamblingController {
    public function section(): string; // Homepage section
    public function index(): string; // Full page
    public function api(): void; // JSON API
    public function crisis(): void; // Crisis resources API
    public function provincial(): void; // Provincial resources API
    public function assessment(): void; // Assessment tools API
}
```

### Routes
```php
// Problem Gambling routes
$router->get('/problem-gambling', 'ProblemGamblingController@index');
$router->get('/api/problem-gambling', 'ProblemGamblingController@api');
$router->get('/api/problem-gambling/crisis', 'ProblemGamblingController@crisis');
$router->get('/api/problem-gambling/provincial', 'ProblemGamblingController@provincial');
$router->get('/api/problem-gambling/assessment', 'ProblemGamblingController@assessment');
```

## Quality Assurance

### Testing Requirements
- **Accessibility Testing**: WCAG 2.1 AA compliance for users in crisis
- **Mobile Testing**: Ensure all resources accessible on mobile devices
- **Link Testing**: Verify all helpline numbers and websites are current
- **Load Testing**: Critical section must load quickly in emergencies
- **Content Review**: Expert review of all mental health resources

### Acceptance Criteria
- [ ] Crisis support information displays prominently
- [ ] All helpline numbers are clickable on mobile devices
- [ ] Provincial resources load based on user location
- [ ] Self-assessment questionnaire functions correctly
- [ ] All external links open in new tabs
- [ ] Section is accessible to users with disabilities
- [ ] Content is medically/psychologically appropriate
- [ ] Resources are current and verified

### Test Cases
```gherkin
Feature: Problem Gambling Resources

Scenario: User in crisis needs immediate help
  Given a user is experiencing gambling-related crisis
  When they visit the homepage
  Then they should see prominent crisis support information
  And helpline numbers should be clickable on mobile

Scenario: User wants to assess their gambling behavior
  Given a user is concerned about their gambling
  When they complete the self-assessment questionnaire
  Then they should receive appropriate scoring and resources
  And next steps should be clearly indicated

Scenario: User needs provincial-specific resources
  Given a user is in Ontario
  When they view provincial resources
  Then they should see Ontario-specific helplines and services
  And information should be current and accurate
```

## Deployment Strategy

### Implementation Plan
1. **Phase 1**: Create service layer with crisis support data
2. **Phase 2**: Implement controller and basic views
3. **Phase 3**: Add self-assessment functionality
4. **Phase 4**: Integrate provincial resources
5. **Phase 5**: Style and responsive design
6. **Phase 6**: Testing and content verification
7. **Phase 7**: Deploy and validate

### Risk Mitigation
- **Content Accuracy**: Verify all helpline numbers and resources
- **Legal Compliance**: Ensure meets Canadian responsible gambling requirements
- **Accessibility**: Priority testing for users with disabilities
- **Crisis Situations**: Immediate access to help must be guaranteed
- **Regular Updates**: Maintain current contact information and resources

## Success Metrics

### Performance KPIs
- Page load time < 2 seconds (critical for crisis situations)
- Mobile accessibility score > 95%
- Resource click-through rate > 15%
- User engagement with self-assessment tools
- Reduction in customer service gambling-related inquiries

### Business Impact
- Enhanced regulatory compliance
- Improved brand trust and reputation
- SEO improvement for responsible gambling terms
- Reduced legal liability
- Demonstration of social responsibility

## Conclusion

The Problem Gambling Resources section is essential for regulatory compliance, user safety, and building trust with Canadian players. By providing comprehensive, accessible, and current resources, we demonstrate our commitment to responsible gambling while meeting the highest standards of player protection.

This implementation will position us as a responsible operator that prioritizes player welfare, ultimately strengthening our brand reputation and regulatory standing in the Canadian market.
