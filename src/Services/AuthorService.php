<?php
namespace App\Services;

class AuthorService {
    private $authors = [
        [
            'name' => 'Michael Thompson',
            'bio' => 'Senior Casino Analyst with 12+ years in the Canadian gambling industry. Former pit boss at Casino Montreal.',
            'expertise' => ['Live Casino', 'Table Games', 'Bonus Analysis'],
            'location' => 'Toronto, ON',
            'credentials' => 'Certified Gaming Professional (CGP), University of Waterloo MBA',
            'photo' => '/images/authors/michael-thompson.jpg'
        ],
        [
            'name' => 'Sarah Chen',
            'bio' => 'Digital gambling expert and former regulatory consultant for the Ontario Gaming Commission.',
            'expertise' => ['Online Slots', 'Mobile Gaming', 'Payment Methods'],
            'location' => 'Vancouver, BC',
            'credentials' => 'Masters in Statistics, SFU. 8 years regulatory experience',
            'photo' => '/images/authors/sarah-chen.jpg'
        ],
        [
            'name' => 'David Rodriguez',
            'bio' => 'Professional poker player turned casino reviewer. Winner of multiple WSOP Circuit events.',
            'expertise' => ['Poker', 'Strategy Games', 'VIP Programs'],
            'location' => 'Calgary, AB',
            'credentials' => 'WSOP Circuit Champion, Professional Gambler since 2015',
            'photo' => '/images/authors/david-rodriguez.jpg'
        ],
        [
            'name' => 'Jennifer Walsh',
            'bio' => 'Former marketing director at Woodbine Casino. Expert in casino bonuses and promotions.',
            'expertise' => ['Bonuses', 'Promotions', 'Player Rewards'],
            'location' => 'Ottawa, ON',
            'credentials' => 'MBA Marketing, 10+ years casino industry experience',
            'photo' => '/images/authors/jennifer-walsh.jpg'
        ],
        [
            'name' => 'Robert Kim',
            'bio' => 'Technology journalist specializing in gaming software and security. Former software engineer.',
            'expertise' => ['Software Analysis', 'Security', 'Game Testing'],
            'location' => 'Montreal, QC',
            'credentials' => 'Computer Science Degree McGill, Tech journalist 6 years',
            'photo' => '/images/authors/robert-kim.jpg'
        ],
        [
            'name' => 'Amanda Foster',
            'bio' => 'Slot machine specialist and former game designer. Expert in RTP analysis and volatility.',
            'expertise' => ['Slot Games', 'RTP Analysis', 'Game Mechanics'],
            'location' => 'Halifax, NS',
            'credentials' => 'Game Design Certificate, 7 years industry experience',
            'photo' => '/images/authors/amanda-foster.jpg'
        ],
        [
            'name' => 'James Morrison',
            'bio' => 'Casino security consultant and former RCMP officer. Expert in online gambling safety.',
            'expertise' => ['Security', 'Fair Play', 'Legal Compliance'],
            'location' => 'Winnipeg, MB',
            'credentials' => 'Former RCMP, 15 years law enforcement, Gaming Security Specialist',
            'photo' => '/images/authors/james-morrison.jpg'
        ],
        [
            'name' => 'Lisa Patel',
            'bio' => 'Mathematics professor and gambling probability expert. Regular contributor to gaming publications.',
            'expertise' => ['Probability', 'House Edge', 'Statistical Analysis'],
            'location' => 'Edmonton, AB',
            'credentials' => 'PhD Mathematics, University of Alberta Professor',
            'photo' => '/images/authors/lisa-patel.jpg'
        ]
    ];

    public function getRandomAuthor(): array {
        return $this->authors[array_rand($this->authors)];
    }

    public function getAuthorByExpertise(string $expertise): array {
        $matchingAuthors = array_filter($this->authors, function($author) use ($expertise) {
            return in_array($expertise, $author['expertise']);
        });

        if (empty($matchingAuthors)) {
            return $this->getRandomAuthor();
        }

        return $matchingAuthors[array_rand($matchingAuthors)];
    }

    public function getAuthorByName(string $name): ?array {
        foreach ($this->authors as $author) {
            if ($author['name'] === $name) {
                return $author;
            }
        }
        return null;
    }

    public function getAllAuthors(): array {
        return $this->authors;
    }

    public function formatAuthorByline(array $author): string {
        return "By {$author['name']} | {$author['location']} | Updated " . date('M j, Y');
    }

    public function formatAuthorBio(array $author): string {
        return "{$author['bio']} Specializes in: " . implode(', ', $author['expertise']) . ".";
    }
}
