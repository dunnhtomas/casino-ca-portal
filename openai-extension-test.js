// OpenAI Extension Test File
// Use this with the andrewbutson.vscode-openai extension to test the API key

/*
API Key: [REDACTED - Use environment variable or extension settings]

Instructions for testing:
1. With the OpenAI extension installed, you can now:
   - Press Ctrl+Shift+P (Command Palette)
   - Type "OpenAI" to see available commands
   - Set your API key in the extension settings
   - Test a simple prompt

2. To configure the API key:
   - Go to VS Code Settings (Ctrl+,)
   - Search for "openai"
   - Set your API key in the OpenAI extension settings
   
3. Test prompt to try:
   "Generate a brief JSON structure for a casino with name, rating, games count, and welcome bonus."

This will help us verify if the API key works with the extension,
which uses the same OpenAI API endpoints.
*/

// Sample casino data for testing
const testCasino = {
    name: "BonRush",
    website: "https://bonrush.com",
    tier: "premium",
    baseRating: 8.2
};

console.log("Casino data ready for OpenAI testing:", testCasino);
