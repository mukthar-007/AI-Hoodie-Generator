# AI Hoodie Generator

An AI-powered Laravel application that generates hoodie designs based on a user’s text prompt, creates product mockups, and prepares titles/descriptions — ready for e-commerce publishing.

## Features

- Generate custom hoodie designs using OpenAI’s DALL·E API.

- Upload generated images to Printful for printing & fulfillment.

- Automatically create mockups of hoodies with the AI-generated design.

- Generate product titles & descriptions using GPT.

- Supports Web UI and REST API access.

## Tech Stack

- **Backend:** Laravel 11

- **AI Image Generation:** OpenAI DALL·E API

- **E-Commerce Mockups:** Printful API

- **Language Generation:** OpenAI GPT API

## Installation & Setup

1. ### Clone the repo

    git clone https://github.com/mukthar-007/AI-Hoodie-Generator.git

    cd hoodie-generator

2. ### Install dependencies

    composer install
   
    npm install && npm run dev

4. ### Set environment variables in .env:

    OPENAI_API_KEY=your_openai_api_key
   
    PRINTFUL_API_KEY=your_printful_api_key

5. ### Serve the application

    php artisan serve

## How It Works (Approach)
1. User enters a text prompt (e.g., "Cyberpunk lion hoodie").

2. AI generates an image using DALL·E.

3. The image is uploaded to Printful as a design file.

4. Printful creates a hoodie mockup using the design.

5. GPT generates a product title & description for the hoodie.

6. The system returns JSON (API) or renders preview (Web).

##  Web Usage
- **Visit:**
    http://localhost:8000/ai-hoodie
- Enter a prompt → Click Generate Hoodie → View results.

<img width="1900" height="1331" alt="127 0 0 1_8000_hoodie-generator (1)" src="https://github.com/user-attachments/assets/6657dd6a-1735-4382-a90c-96d63e8dd869" />


## API Usage
- **Endpoint:** POST /api/ai-hoodie

<img width="1378" height="764" alt="image" src="https://github.com/user-attachments/assets/86e17dcd-46db-4b64-b3d8-fb949f114c36" />




## Error Handling
- **Invalid prompt** → returns 422 with validation errors.

- **AI API error** → returns 500 with error details.

- **Printful API error** → returns 500 with message from Printful.

- All exceptions are wrapped in try/catch for safety.
