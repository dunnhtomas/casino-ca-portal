<?php

namespace App\Services;

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
    
    public function getSelfAssessmentQuestions() {
        $resources = $this->getGamblingResources();
        return $resources['self_assessment_tools']['brief_questionnaire'];
    }
    
    public function calculatePGSIScore($answers) {
        $totalScore = 0;
        $scoring = $this->getSelfAssessmentQuestions()['scoring'];
        
        foreach ($answers as $answer) {
            $totalScore += $scoring[$answer] ?? 0;
        }
        
        $interpretation = $this->getSelfAssessmentQuestions()['interpretation'];
        
        if ($totalScore == 0) {
            return ['score' => $totalScore, 'level' => 'no_problem', 'message' => $interpretation['0']];
        } elseif ($totalScore <= 2) {
            return ['score' => $totalScore, 'level' => 'low_risk', 'message' => $interpretation['1-2']];
        } elseif ($totalScore <= 7) {
            return ['score' => $totalScore, 'level' => 'moderate_risk', 'message' => $interpretation['3-7']];
        } else {
            return ['score' => $totalScore, 'level' => 'high_risk', 'message' => $interpretation['8+']];
        }
    }
    
    public function getProvincialResource($province) {
        $resources = $this->getGamblingResources();
        return $resources['crisis_resources']['provincial_resources'][$province] ?? null;
    }
    
    public function getWarningSigns() {
        $resources = $this->getGamblingResources();
        return $resources['self_assessment_tools']['warning_signs'];
    }
    
    public function getResponsibleGamblingTools() {
        $resources = $this->getGamblingResources();
        return $resources['responsible_gambling_tools'];
    }
    
    public function getTreatmentOptions() {
        $resources = $this->getGamblingResources();
        return $resources['treatment_options'];
    }
}
