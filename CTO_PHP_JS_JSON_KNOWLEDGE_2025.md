# CTO-Level PHP, JavaScript, and JSON Knowledge Base 2025

## PHP 8.3+ Best Practices (2025)

### Null Safety and Type Safety
```php
// ✅ Modern null-safe operator (PHP 8.0+)
$value = $array['key'] ?? null;
$result = $object?->method()?->property ?? 'default';

// ✅ Proper null checks for arrays
if (!empty($array) && is_array($array)) {
    foreach ($array as $item) {
        // Safe iteration
    }
}

// ✅ Type declarations (PHP 8.0+)
function processData(?string $input = null): string {
    return $input ?? '';
}

// ✅ Union types (PHP 8.0+)
function handleValue(string|int|null $value): string {
    return match(gettype($value)) {
        'string' => $value,
        'integer' => (string)$value,
        'NULL' => '',
        default => throw new InvalidArgumentException()
    };
}
```

### Array and Data Handling
```php
// ✅ Safe array access patterns
$safeValue = array_key_exists('key', $array) ? $array['key'] : null;
$safeValue = isset($array['key']) ? $array['key'] : 'default';
$safeValue = $array['key'] ?? 'default';

// ✅ Safe JSON handling
try {
    $data = json_decode($json, true, 512, JSON_THROW_ON_ERROR);
} catch (JsonException $e) {
    // Handle JSON parsing errors
    $data = [];
}

// ✅ Safe HTML output
echo htmlspecialchars($userInput ?? '', ENT_QUOTES | ENT_HTML5, 'UTF-8');

// ✅ Modern array functions
$filtered = array_filter($array, fn($item) => !empty($item));
$mapped = array_map(fn($item) => $item['name'] ?? 'Unknown', $array);
```

### Error Handling and Debugging
```php
// ✅ Modern exception handling
class ValidationException extends Exception {
    public function __construct(string $message, array $errors = []) {
        parent::__construct($message);
        $this->errors = $errors;
    }
}

// ✅ Proper error context
function validateData(array $data): void {
    $errors = [];
    
    if (empty($data['name'])) {
        $errors['name'] = 'Name is required';
    }
    
    if (!empty($errors)) {
        throw new ValidationException('Validation failed', $errors);
    }
}
```

## JavaScript ES2024+ Best Practices

### Modern Syntax and Safety
```javascript
// ✅ Optional chaining and nullish coalescing
const value = data?.user?.profile?.name ?? 'Anonymous';

// ✅ Safe array/object checks
const safeArray = Array.isArray(data) ? data : [];
const safeObject = data && typeof data === 'object' ? data : {};

// ✅ Modern async/await with error handling
async function fetchData(url) {
    try {
        const response = await fetch(url);
        if (!response.ok) {
            throw new Error(`HTTP ${response.status}: ${response.statusText}`);
        }
        return await response.json();
    } catch (error) {
        console.error('Fetch error:', error);
        return null;
    }
}

// ✅ Modern destructuring with defaults
const { name = 'Unknown', age = 0, features = [] } = user ?? {};
```

### DOM Manipulation and Event Handling
```javascript
// ✅ Modern event handling
document.addEventListener('DOMContentLoaded', () => {
    // Safe element selection
    const element = document.querySelector('#myElement');
    if (element) {
        element.addEventListener('click', handleClick);
    }
});

// ✅ Safe data attribute access
function getDataAttribute(element, attribute) {
    return element?.dataset?.[attribute] ?? null;
}

// ✅ Modern form handling
function collectFormData(formElement) {
    if (!(formElement instanceof HTMLFormElement)) {
        throw new Error('Invalid form element');
    }
    
    const formData = new FormData(formElement);
    return Object.fromEntries(formData.entries());
}
```

### Performance and Memory Management
```javascript
// ✅ Debouncing for performance
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func.apply(this, args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

// ✅ Modern module patterns
class CasinoGrid {
    #privateData = new Map();
    
    constructor(options = {}) {
        this.options = { 
            debounceTime: 300,
            pageSize: 20,
            ...options 
        };
    }
    
    async loadData(filters = {}) {
        try {
            const response = await this.#fetchWithTimeout('/api/casinos', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(filters)
            });
            
            return await response.json();
        } catch (error) {
            this.#handleError(error);
            return { casinos: [], total: 0 };
        }
    }
    
    #fetchWithTimeout(url, options = {}, timeout = 5000) {
        return Promise.race([
            fetch(url, options),
            new Promise((_, reject) => 
                setTimeout(() => reject(new Error('Timeout')), timeout)
            )
        ]);
    }
    
    #handleError(error) {
        console.error('Casino Grid Error:', error);
        // Send to error tracking service
    }
}
```

## JSON Schema and Validation (2025)

### Strict JSON Structure
```json
{
  "schema": "https://json-schema.org/draft/2020-12/schema",
  "type": "object",
  "properties": {
    "casinos": {
      "type": "array",
      "items": {
        "type": "object",
        "required": ["id", "name", "rating"],
        "properties": {
          "id": { "type": "integer", "minimum": 1 },
          "name": { "type": "string", "minLength": 1, "maxLength": 100 },
          "rating": { "type": "number", "minimum": 0, "maximum": 5 },
          "established": { "type": ["integer", "null"] },
          "features": {
            "type": "array",
            "items": { "type": "string" },
            "default": []
          }
        }
      }
    }
  }
}
```

### Safe JSON Generation in PHP
```php
// ✅ Safe JSON encoding with error handling
function safeJsonEncode($data, int $flags = JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES): string {
    try {
        $json = json_encode($data, $flags | JSON_THROW_ON_ERROR);
        return $json;
    } catch (JsonException $e) {
        error_log("JSON encoding error: " . $e->getMessage());
        return '{}';
    }
}

// ✅ Data sanitization before JSON
function sanitizeForJson($data) {
    if (is_array($data)) {
        return array_map('sanitizeForJson', $data);
    }
    
    if (is_string($data)) {
        return mb_convert_encoding($data, 'UTF-8', 'UTF-8');
    }
    
    return $data;
}
```

## Integration Patterns (PHP + JavaScript + JSON)

### Server-Side Data Preparation
```php
// ✅ Safe data transformation for frontend
class CasinoDataTransformer {
    public static function transformForGrid(array $casinos): array {
        return array_map([self::class, 'transformSingleCasino'], $casinos);
    }
    
    private static function transformSingleCasino(?array $casino): array {
        if (!is_array($casino)) {
            return self::getDefaultCasino();
        }
        
        return [
            'id' => (int)($casino['id'] ?? 0),
            'name' => trim($casino['name'] ?? ''),
            'slug' => $casino['slug'] ?? '',
            'rating' => (float)($casino['rating'] ?? 0),
            'established' => $casino['established'] ? (int)$casino['established'] : null,
            'features' => array_filter((array)($casino['features'] ?? []), 'strlen'),
            'welcome_bonus' => trim($casino['welcome_bonus'] ?? ''),
            'game_count' => (int)($casino['game_count'] ?? 0),
            'categories' => array_map([self::class, 'transformCategory'], 
                              (array)($casino['categories'] ?? [])),
            'meta' => [
                'updated_at' => $casino['updated_at'] ?? date('c'),
                'verified' => (bool)($casino['verified'] ?? false)
            ]
        ];
    }
    
    private static function transformCategory(?array $category): array {
        return [
            'id' => (int)($category['id'] ?? 0),
            'name' => trim($category['name'] ?? ''),
            'slug' => $category['slug'] ?? ''
        ];
    }
    
    private static function getDefaultCasino(): array {
        return [
            'id' => 0,
            'name' => 'Unknown Casino',
            'slug' => 'unknown',
            'rating' => 0.0,
            'established' => null,
            'features' => [],
            'welcome_bonus' => '',
            'game_count' => 0,
            'categories' => [],
            'meta' => [
                'updated_at' => date('c'),
                'verified' => false
            ]
        ];
    }
}
```

### Frontend Data Consumption
```javascript
// ✅ Safe data consumption with validation
class DataValidator {
    static validateCasino(casino) {
        const required = ['id', 'name', 'rating'];
        
        if (!casino || typeof casino !== 'object') {
            return false;
        }
        
        return required.every(field => 
            casino.hasOwnProperty(field) && casino[field] !== null
        );
    }
    
    static sanitizeCasinos(rawData) {
        if (!Array.isArray(rawData)) {
            console.warn('Expected array of casinos, got:', typeof rawData);
            return [];
        }
        
        return rawData
            .filter(this.validateCasino)
            .map(this.normalizeCasino);
    }
    
    static normalizeCasino(casino) {
        return {
            id: parseInt(casino.id) || 0,
            name: String(casino.name || '').trim(),
            rating: parseFloat(casino.rating) || 0,
            established: casino.established ? parseInt(casino.established) : null,
            features: Array.isArray(casino.features) ? casino.features : [],
            categories: Array.isArray(casino.categories) ? casino.categories : [],
            // Computed properties
            displayRating: Math.max(0, Math.min(5, parseFloat(casino.rating) || 0)),
            isNew: casino.established && casino.established >= new Date().getFullYear() - 2
        };
    }
}
```

## Common Anti-Patterns to Avoid (2025)

### PHP Anti-Patterns
```php
// ❌ Unsafe array access
echo $array['key']; // Can cause undefined index warning

// ✅ Safe alternative
echo $array['key'] ?? '';

// ❌ Unsafe JSON in templates
<script>var data = <?= json_encode($data) ?>;</script>

// ✅ Safe alternative with CDATA and escaping
<script>
//<![CDATA[
var data = <?= json_encode($data, JSON_UNESCAPED_SLASHES | JSON_HEX_TAG) ?>;
//]]>
</script>

// ❌ Direct user input in HTML
echo $userInput;

// ✅ Properly escaped output
echo htmlspecialchars($userInput ?? '', ENT_QUOTES | ENT_HTML5, 'UTF-8');
```

### JavaScript Anti-Patterns
```javascript
// ❌ Unsafe object access
const name = user.profile.name; // Can throw TypeError

// ✅ Safe alternative
const name = user?.profile?.name ?? 'Unknown';

// ❌ Unsafe array iteration
data.forEach(item => console.log(item.name)); // Fails if data is not array

// ✅ Safe alternative
const safeData = Array.isArray(data) ? data : [];
safeData.forEach(item => console.log(item?.name ?? 'No name'));

// ❌ Memory leaks with event listeners
function addListener() {
    document.addEventListener('click', () => {
        // Heavy operation without cleanup
    });
}

// ✅ Proper cleanup
class ComponentManager {
    constructor() {
        this.listeners = [];
    }
    
    addListener(element, event, handler) {
        element.addEventListener(event, handler);
        this.listeners.push({ element, event, handler });
    }
    
    cleanup() {
        this.listeners.forEach(({ element, event, handler }) => {
            element.removeEventListener(event, handler);
        });
        this.listeners = [];
    }
}
```

## 2025 Security Considerations

### Data Sanitization
```php
// ✅ Comprehensive input sanitization
class InputSanitizer {
    public static function sanitizeString(?string $input, int $maxLength = 255): string {
        if ($input === null) return '';
        
        $clean = trim($input);
        $clean = filter_var($clean, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
        
        return mb_substr($clean, 0, $maxLength, 'UTF-8');
    }
    
    public static function sanitizeArray(?array $input): array {
        if (!is_array($input)) return [];
        
        return array_map(function($item) {
            if (is_string($item)) {
                return self::sanitizeString($item);
            }
            if (is_array($item)) {
                return self::sanitizeArray($item);
            }
            return $item;
        }, $input);
    }
}
```

### Frontend Security
```javascript
// ✅ Safe DOM insertion
function safeInsertHTML(element, content) {
    if (!(element instanceof Element)) {
        throw new Error('Invalid element');
    }
    
    // Create a temporary container for parsing
    const temp = document.createElement('div');
    temp.textContent = content; // This escapes HTML
    element.appendChild(temp.firstChild);
}

// ✅ CSRF protection
class ApiClient {
    constructor() {
        this.csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
    }
    
    async request(url, options = {}) {
        const headers = {
            'X-CSRF-TOKEN': this.csrfToken,
            'Content-Type': 'application/json',
            ...options.headers
        };
        
        return fetch(url, { ...options, headers });
    }
}
```

This knowledge base reflects 2025 CTO-level best practices for PHP 8.3+, JavaScript ES2024+, and modern JSON handling with security, performance, and maintainability as core principles.
