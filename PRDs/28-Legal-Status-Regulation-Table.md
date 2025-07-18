# PRD #28: Legal Status & Regulation Table Section

## Overview
Implement a comprehensive Legal Status & Regulation Table section that provides clear information about online gambling legality across Canadian provinces, regulatory frameworks, licensing requirements, and compliance guidelines for Canadian players.

## Business Requirements

### User Stories
- **As a Canadian casino player**, I want to understand the legal status of online gambling in my province
- **As a compliance-conscious user**, I want to see which casinos are properly licensed and regulated
- **As a responsible gambler**, I want to know the legal framework protecting me
- **As a newcomer to online gambling**, I want clear guidance on what's legal and safe

### Value Proposition
- **Compliance Assurance**: Clear legal guidance builds user confidence
- **Regional Specificity**: Province-specific information for accurate guidance
- **Trust Building**: Demonstrates site's commitment to legal compliance
- **Educational Value**: Helps users understand complex gambling laws

## Functional Requirements

### Core Features
1. **Provincial Legal Status Table**
   - All 13 provinces and territories
   - Current legal status for each region
   - Regulatory authorities and contact information
   - Age restrictions and requirements
   - Key legal updates and changes

2. **Federal vs Provincial Framework**
   - Criminal Code of Canada overview
   - Provincial jurisdiction boundaries
   - iGaming Ontario specific information
   - First Nations gaming rights
   - Cross-border gambling rules

3. **Licensing & Regulation Information**
   - Required licensing authorities
   - Licensed operator lists
   - Regulatory compliance requirements
   - Consumer protection measures
   - Dispute resolution processes

4. **Player Protection Framework**
   - Responsible gambling requirements
   - Self-exclusion programs
   - Age verification processes
   - Privacy and data protection
   - Financial consumer protections

5. **Compliance Guidelines**
   - Legal casino selection criteria
   - Red flags to avoid
   - Verification processes
   - Tax implications for winnings
   - Legal gambling practices

6. **Regional Updates & News**
   - Recent regulatory changes
   - Upcoming legislation
   - Provincial policy updates
   - Industry developments
   - Legal precedents

### Technical Implementation

#### Service Layer (`LegalStatusService.php`)
```php
class LegalStatusService {
    public function getProvincialLegalStatus(): array
    public function getFederalFramework(): array
    public function getLicensingInformation(): array
    public function getPlayerProtections(): array
    public function getComplianceGuidelines(): array
    public function getRegionalUpdates(): array
    public function getLegalStatistics(): array
    public function getRegulatoryContacts(): array
}
```

#### Controller (`LegalStatusController.php`)
- Homepage section rendering
- Dedicated legal status page
- Provincial-specific pages
- API endpoints for legal data
- Regulatory update feeds

#### Views
- `section.php` - Homepage legal status section
- `index.php` - Complete legal status page
- `provincial.php` - Province-specific legal information
- `framework.php` - Federal framework explanation
- `compliance.php` - Compliance guidelines page

## Design Requirements

### Homepage Section Design
- **Header**: "Legal Status & Regulation" with official government iconography
- **Provincial Overview Table**: All 13 provinces with status indicators
- **Key Statistics**: Licensed operators, regulatory authorities, protected players
- **Federal Framework Summary**: Brief overview of Canadian gambling law
- **Compliance Highlights**: Essential legal requirements
- **CTA**: Link to comprehensive legal guide

### Visual Elements
- **Status Indicators**: Green (legal), Yellow (regulated), Red (restricted)
- **Official Badges**: Government and regulatory authority logos
- **Interactive Map**: Canadian provinces with clickable regions
- **Legal Icons**: Scales of justice, official seals, compliance badges
- **Document References**: Links to official legislation and regulations

### Data Visualization
- **Legal Status Matrix**: Province vs. gambling type (casino, sports, lottery)
- **Regulatory Timeline**: Evolution of Canadian gambling law
- **Compliance Checklist**: Visual guidelines for legal gambling
- **Protection Measures**: Consumer safeguards and rights

## Content Requirements

### Provincial Legal Framework
1. **Ontario**: iGaming Ontario (iGO) regulated market
2. **Quebec**: Espacejeux.com monopoly model
3. **British Columbia**: BCLC online platform
4. **Alberta**: AGLC regulated options
5. **Manitoba**: Manitoba Liquor & Lotteries
6. **Saskatchewan**: SaskGaming framework
7. **Nova Scotia**: Atlantic Lottery Corporation
8. **New Brunswick**: Atlantic Lottery Corporation
9. **Prince Edward Island**: Atlantic Lottery Corporation
10. **Newfoundland and Labrador**: Atlantic Lottery Corporation
11. **Northwest Territories**: Territorial regulations
12. **Nunavut**: Territorial regulations
13. **Yukon**: Territorial regulations

### Federal Framework
- **Criminal Code Section 207**: Provincial jurisdiction over gambling
- **Kahnawake Gaming Commission**: First Nations gaming authority
- **Competition Bureau**: Consumer protection oversight
- **FINTRAC**: Anti-money laundering compliance
- **CRA**: Taxation of gambling winnings

### Regulatory Authorities
- **iGaming Ontario (iGO)**: Ontario's regulated market operator
- **Régie des alcools, des courses et des jeux (RACJ)**: Quebec regulator
- **British Columbia Lottery Corporation (BCLC)**: BC gaming authority
- **Alberta Gaming, Liquor and Cannabis (AGLC)**: Alberta regulator
- **Kahnawake Gaming Commission**: Indigenous gaming authority

## API Requirements

### Endpoints
- `GET /api/legal-status` - Complete legal framework data
- `GET /api/legal-status/provincial` - Provincial status breakdown
- `GET /api/legal-status/federal` - Federal framework information
- `GET /api/legal-status/licensing` - Licensing requirements
- `GET /api/legal-status/province/{code}` - Province-specific data

### Data Structure
```json
{
  "legal_framework": {
    "federal": {
      "criminal_code": "string",
      "provincial_jurisdiction": "string",
      "key_legislation": []
    },
    "provincial": [
      {
        "province": "Ontario",
        "code": "ON",
        "legal_status": "Regulated",
        "regulator": "iGaming Ontario",
        "age_requirement": 19,
        "licensing_required": true,
        "consumer_protections": [],
        "contact_info": {}
      }
    ]
  },
  "licensing": {},
  "player_protections": {},
  "compliance_guidelines": {}
}
```

## Database Schema

### Tables Required
```sql
-- Provincial legal status information
CREATE TABLE provincial_legal_status (
    id INT PRIMARY KEY,
    province_name VARCHAR(100),
    province_code CHAR(2),
    legal_status ENUM('Legal', 'Regulated', 'Restricted', 'Prohibited'),
    regulator_name VARCHAR(200),
    regulator_website VARCHAR(255),
    age_requirement INT,
    licensing_required BOOLEAN,
    last_updated DATE,
    created_at TIMESTAMP
);

-- Regulatory authorities and contacts
CREATE TABLE regulatory_authorities (
    id INT PRIMARY KEY,
    name VARCHAR(200),
    jurisdiction VARCHAR(100),
    authority_type ENUM('Federal', 'Provincial', 'Territorial', 'Indigenous'),
    contact_phone VARCHAR(20),
    contact_email VARCHAR(100),
    website VARCHAR(255),
    address TEXT,
    created_at TIMESTAMP
);

-- Legal framework documentation
CREATE TABLE legal_framework (
    id INT PRIMARY KEY,
    category ENUM('Federal', 'Provincial', 'Licensing', 'Consumer Protection'),
    title VARCHAR(200),
    description TEXT,
    legislation_reference VARCHAR(100),
    effective_date DATE,
    source_url VARCHAR(255),
    created_at TIMESTAMP
);

-- Player protection measures
CREATE TABLE player_protections (
    id INT PRIMARY KEY,
    protection_type VARCHAR(100),
    description TEXT,
    applicable_provinces JSON,
    implementation_details TEXT,
    contact_information JSON,
    created_at TIMESTAMP
);
```

## SEO Requirements

### Meta Data
- **Title**: "Canadian Online Gambling Laws & Regulations | Legal Status by Province"
- **Description**: "Complete guide to online gambling legality in Canada. Provincial regulations, licensing requirements, player protections, and compliance guidelines for safe gambling."
- **Keywords**: "Canadian gambling laws, online casino legal status, provincial gambling regulations, iGaming Ontario"

### Schema.org Markup
```json
{
  "@context": "https://schema.org",
  "@type": "GovernmentService",
  "name": "Canadian Online Gambling Legal Framework",
  "description": "Legal status and regulatory information for online gambling in Canada",
  "areaServed": {
    "@type": "Country",
    "name": "Canada"
  },
  "provider": {
    "@type": "GovernmentOrganization",
    "name": "Government of Canada"
  }
}
```

### Internal Linking
- Link to province-specific casino recommendations
- Connect to responsible gambling resources
- Reference licensing verification guides
- Link to regulatory authority pages

## Performance Requirements

### Loading Speed
- Page load time: < 2 seconds
- Table rendering optimization
- Lazy loading for detailed content
- Efficient data caching

### Data Accuracy
- Real-time regulatory updates
- Automated compliance monitoring
- Official source verification
- Regular legal review process

## Security Requirements

### Compliance Standards
- Accurate legal information representation
- Official source documentation
- Regular legal review and updates
- Disclaimer and liability protection

## Acceptance Criteria

### Homepage Integration
- [ ] Legal status section displays prominently on homepage
- [ ] Provincial status table with all 13 provinces
- [ ] Visual status indicators (legal/regulated/restricted)
- [ ] Key regulatory statistics displayed
- [ ] Federal framework summary included
- [ ] Links to detailed legal information
- [ ] Responsive design works on all devices
- [ ] Loads in under 2 seconds

### Dedicated Legal Page
- [ ] Comprehensive legal framework explanation
- [ ] Detailed provincial breakdown with regulators
- [ ] Federal vs provincial jurisdiction clarification
- [ ] Licensing requirements and processes
- [ ] Player protection measures outlined
- [ ] Compliance guidelines provided
- [ ] Official contact information included
- [ ] Regular update mechanism in place

### Provincial Information
- [ ] All 13 provinces and territories covered
- [ ] Accurate legal status for each region
- [ ] Regulatory authority contact information
- [ ] Age requirements and restrictions
- [ ] Consumer protection measures
- [ ] Recent legal updates included

### API Functionality
- [ ] All endpoints return accurate legal data
- [ ] Province-specific information available
- [ ] Federal framework data accessible
- [ ] Response times under 200ms
- [ ] Error handling implemented
- [ ] Official source references included

### Compliance & Accuracy
- [ ] All legal information verified with official sources
- [ ] Regulatory contact information current
- [ ] Legal disclaimers appropriately placed
- [ ] Update mechanism for regulatory changes
- [ ] Professional legal review completed

## Testing Requirements

### Functional Testing
- [ ] Homepage section renders correctly
- [ ] All provincial data displays accurately
- [ ] Legal status indicators work properly
- [ ] API endpoints return valid data
- [ ] Mobile responsiveness verified

### Content Accuracy Testing
- [ ] Legal information verified with official sources
- [ ] Regulatory contact information validated
- [ ] Provincial status accuracy confirmed
- [ ] Federal framework representation accurate
- [ ] Compliance guidelines legally sound

### Performance Testing
- [ ] Page load speed tests passed
- [ ] Table rendering performance optimized
- [ ] API response time verification
- [ ] Mobile performance validated

## Launch Checklist

### Pre-Launch
- [ ] All legal data verified with official sources
- [ ] Provincial information accuracy confirmed
- [ ] Regulatory contacts validated
- [ ] Legal disclaimers reviewed
- [ ] Professional legal consultation completed

### Post-Launch
- [ ] Homepage integration verified
- [ ] All provincial pages accessible
- [ ] API endpoints functional
- [ ] Legal accuracy monitoring active
- [ ] Update procedures established

### Validation
- [ ] Legal professional review completed
- [ ] Official source verification done
- [ ] Compliance standards met
- [ ] User accessibility confirmed
- [ ] SEO optimization verified

## Success Metrics

### User Engagement
- Time spent on legal information pages > 3 minutes
- Provincial page views > 1000/month
- Legal resource downloads > 200/month
- User feedback on legal clarity positive

### Compliance Metrics
- Legal information accuracy maintained at 100%
- Regulatory update response time < 48 hours
- Official source verification quarterly
- Zero legal compliance issues

### SEO Performance
- Ranking for "Canadian gambling laws" in top 5
- Organic traffic to legal pages > 2000/month
- Featured snippets for legal queries achieved
- Authority backlinks from legal resources

---

**Priority**: HIGH - Compliance & Trust  
**Estimated Development Time**: 4-5 days  
**Dependencies**: Legal research, official source verification  
**Related PRDs**: #24 (Provinces), #29 (Problem Gambling Resources)
