# 🧠 AI Hoodie Generator

An AI-powered Laravel application that generates hoodie designs based on a user’s text prompt, creates product mockups, and prepares titles/descriptions — ready for e-commerce publishing.

## 🚀 Features

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

## ⚙️ Installation & Setup

1. ### Clone the repo

    git clone https://github.com/mukthar-007/AI-Hoodie-Generator.git

    cd hoodie-generator

2. ### Install dependencies

    composer install
    npm install && npm run dev

3. ### Set environment variables in .env:

    OPENAI_API_KEY=your_openai_api_key
    PRINTFUL_API_KEY=your_printful_api_key

4. ### Serve the application

    php artisan serve

## 🖥 How It Works (Approach)
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

<img width="743" height="414" alt="image" src="https://github.com/user-attachments/assets/47def8b3-0c33-42e7-aad5-251ee7d68c20" />


## API Usage
- **Endpoint:** POST /api/ai-hoodie

## 🛡 Error Handling
- **Invalid prompt** → returns 422 with validation errors.

- **AI API error** → returns 500 with error details.

- **Printful API error** → returns 500 with message from Printful.

- All exceptions are wrapped in try/catch for safety.
