<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Services\ProblemGamblingService;

class ProblemGamblingController extends Controller {
    
    private $gamblingService;
    
    public function __construct() {
        $this->gamblingService = new ProblemGamblingService();
    }
    
    public function section() {
        $emergencyContacts = $this->gamblingService->getEmergencyContacts();
        $warningSigns = $this->gamblingService->getWarningSigns();
        $resources = $this->gamblingService->getGamblingResources();
        
        return $this->render('problem-gambling/section', [
            'emergencyContacts' => $emergencyContacts,
            'warningSigns' => $warningSigns,
            'resources' => $resources
        ]);
    }
    
    public function index() {
        $resources = $this->gamblingService->getGamblingResources();
        $emergencyContacts = $this->gamblingService->getEmergencyContacts();
        $warningSigns = $this->gamblingService->getWarningSigns();
        
        return $this->render('problem-gambling/index', [
            'resources' => $resources,
            'emergencyContacts' => $emergencyContacts,
            'warningSigns' => $warningSigns,
            'pageTitle' => 'Problem Gambling Resources & Support - Get Help Now',
            'metaDescription' => 'Find immediate help for gambling addiction in Canada. 24/7 crisis support, provincial resources, self-assessment tools, and treatment options. Get help now: 1-833-456-4566'
        ]);
    }
    
    public function selfAssessment() {
        $assessment = $this->gamblingService->getSelfAssessmentQuestions();
        $warningSigns = $this->gamblingService->getWarningSigns();
        
        return $this->render('problem-gambling/assessment', [
            'assessment' => $assessment,
            'warningSigns' => $warningSigns,
            'pageTitle' => 'Problem Gambling Self-Assessment (PGSI) - Check Your Risk Level',
            'metaDescription' => 'Take the Problem Gambling Severity Index (PGSI) self-assessment. Confidential 9-question test to evaluate your gambling behavior and risk level.'
        ]);
    }
    
    public function provincialResources($province) {
        $provincialData = $this->gamblingService->getProvincialResource($province);
        
        if (!$provincialData) {
            return $this->render('errors/404');
        }
        
        $provinceName = ucwords(str_replace('_', ' ', $province));
        
        return $this->render('problem-gambling/provincial', [
            'provincialData' => $provincialData,
            'province' => $province,
            'provinceName' => $provinceName,
            'pageTitle' => "Problem Gambling Resources in {$provinceName} - Local Support",
            'metaDescription' => "Find gambling addiction help in {$provinceName}. Local crisis lines, counseling services, and treatment options specific to your province."
        ]);
    }
    
    public function responsibleGamblingTools() {
        $tools = $this->gamblingService->getResponsibleGamblingTools();
        
        return $this->render('problem-gambling/tools', [
            'tools' => $tools,
            'pageTitle' => 'Responsible Gambling Tools - Deposit Limits, Time Controls & Self-Exclusion',
            'metaDescription' => 'Learn about responsible gambling tools: deposit limits, time controls, reality checks, and self-exclusion options to help you gamble safely.'
        ]);
    }
    
    public function treatmentOptions() {
        $treatment = $this->gamblingService->getTreatmentOptions();
        
        return $this->render('problem-gambling/treatment', [
            'treatment' => $treatment,
            'pageTitle' => 'Gambling Addiction Treatment Options in Canada - Professional Help',
            'metaDescription' => 'Professional gambling addiction treatment in Canada: therapy options, support groups, counseling services, and recovery programs.'
        ]);
    }
    
    // API endpoints
    public function apiResources() {
        header('Content-Type: application/json');
        $resources = $this->gamblingService->getGamblingResources();
        echo json_encode($resources, JSON_PRETTY_PRINT);
    }
    
    public function apiEmergencyContacts() {
        header('Content-Type: application/json');
        $contacts = $this->gamblingService->getEmergencyContacts();
        echo json_encode($contacts, JSON_PRETTY_PRINT);
    }
    
    public function apiSelfAssessment() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $input = json_decode(file_get_contents('php://input'), true);
            $answers = $input['answers'] ?? [];
            
            if (count($answers) !== 9) {
                http_response_code(400);
                echo json_encode(['error' => 'Please answer all 9 questions']);
                return;
            }
            
            $result = $this->gamblingService->calculatePGSIScore($answers);
            
            header('Content-Type: application/json');
            echo json_encode($result, JSON_PRETTY_PRINT);
        } else {
            $questions = $this->gamblingService->getSelfAssessmentQuestions();
            header('Content-Type: application/json');
            echo json_encode($questions, JSON_PRETTY_PRINT);
        }
    }
    
    public function apiProvincialResources() {
        header('Content-Type: application/json');
        $resources = $this->gamblingService->getGamblingResources();
        echo json_encode($resources['crisis_resources']['provincial_resources'], JSON_PRETTY_PRINT);
    }
    
    public function apiSupportOrganizations() {
        header('Content-Type: application/json');
        $resources = $this->gamblingService->getGamblingResources();
        echo json_encode($resources['support_organizations'], JSON_PRETTY_PRINT);
    }

    public function apiProvincialResource($province) {
        header('Content-Type: application/json');
        $resource = $this->gamblingService->getProvincialResource($province);
        
        if (!$resource) {
            http_response_code(404);
            echo json_encode(['error' => 'Province not found']);
            return;
        }
        
        echo json_encode($resource, JSON_PRETTY_PRINT);
    }
}
