<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\OpenAIService;
use App\Services\PrintfulService;
use Illuminate\Support\Facades\Log;
use Exception;

class HoodieGeneratorController extends Controller
{
    public function index()
    {
        return view('hoodie-generator');
    }

    public function handleForm(Request $request, OpenAIService $openAI, PrintfulService $printful)
    {
        $request->validate([
            'prompt' => 'required|string|max:255',
            'product_type' => 'required|in:hoodie,tshirt,mug'
        ]);

        $productType = $request->product_type;

        try {
            $imageUrl = $openAI->generateImage($request->prompt);
            if (!$imageUrl) {
                throw new Exception("Failed to generate image from OpenAI.");
            }

            $fileId = $printful->uploadImage($imageUrl);
            if (!$fileId) {
                throw new Exception("Failed to upload image to Printful.");
            }

            $mockupUrl = $printful->generateMockup($fileId, $productType);
            if (!$mockupUrl) {
                throw new Exception("Mockup generation failed or timed out.");
            }

            [$title, $description] = $openAI->generateTitleAndDescription(
                $request->prompt . " " . ucfirst($productType)
            );
            if (!$title || !$description) {
                throw new Exception("Failed to generate product title and description.");
            }

            return view('hoodie-generator', [
                'image_url' => $imageUrl,
                'mockup_url' => $mockupUrl,
                'product_title' => $title,
                'product_description' => $description,
                'prompt' => $request->prompt,
                'product_type' => $productType
            ]);

        } catch (Exception $e) {
            return view('hoodie-generator', [
                'error' => $e->getMessage(),
                'prompt' => $request->prompt,
                'product_type' => $productType
            ]);
        }
    }

    public function generate(Request $request, OpenAIService $openAI, PrintfulService $printful)
    {
        try {
            $request->validate([
                'prompt' => 'required|string|max:255',
                'product_type' => 'required|string|in:hoodie,tshirt,mug'
            ]);

            $prompt = $request->prompt;
            $productType = $request->product_type;

            $imageUrl = $openAI->generateImage($prompt);

            $fileId = $printful->uploadImage($imageUrl);

            $mockupUrl = $printful->generateMockup($fileId, $productType);

            [$title, $description] = $openAI->generateTitleAndDescription($prompt, $productType);

            $responseData = [
                'image_url' => $imageUrl,
                'printful_mockup_url' => $mockupUrl,
                'product_type' => $productType,
                'product_title' => $title,
                'product_description' => $description
            ];

            if ($request->wantsJson()) {
                return response()->json($responseData);
            }

            return view('ai-hoodie.result', $responseData);

        } catch (Exception $e) {
            Log::error('AI Hoodie Generation Error: ' . $e->getMessage());

            $errorMessage = 'Something went wrong while generating your product. Please try again later.';

            if ($request->wantsJson()) {
                return response()->json(['error' => $errorMessage], 500);
            }

            return back()->withErrors(['error' => $errorMessage]);
        }
    }
}

