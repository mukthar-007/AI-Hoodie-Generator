<!DOCTYPE html>
<html>
<head>
    <title>AI Product Generator</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; }
        form { margin-bottom: 30px; }
        input[type="text"], select { width: 300px; padding: 8px; margin-bottom: 10px; }
        button { padding: 8px 15px; background: #333; color: white; border: none; cursor: pointer; }
        .results img { max-width: 300px; display: block; margin-bottom: 10px; border: 1px solid #ddd; }
        .product { margin-top: 20px; }
        .error { background: #f8d7da; color: #721c24; padding: 10px; margin-bottom: 20px; border: 1px solid #f5c6cb; }
    </style>
</head>
<body>
    <h1>AI Product Generator</h1>

    @isset($error)
        <div class="error">
            <strong>Error:</strong> {{ $error }}
        </div>
    @endisset

    <form method="POST" action="{{ url('/hoodie-generator') }}">
        @csrf
        <input type="text" name="prompt" placeholder="Enter your prompt..." value="{{ $prompt ?? '' }}" required><br>
        <select name="product_type" required>
            <option value="hoodie" {{ (isset($product_type) && $product_type === 'hoodie') ? 'selected' : '' }}>Hoodie</option>
            <option value="tshirt" {{ (isset($product_type) && $product_type === 'tshirt') ? 'selected' : '' }}>T-Shirt</option>
            <option value="mug" {{ (isset($product_type) && $product_type === 'mug') ? 'selected' : '' }}>Mug</option>
        </select><br>
        <button type="submit">Generate</button>
    </form>

    @isset($image_url)
    <div class="results">
        <h2>Results for: "{{ $prompt }}" ({{ ucfirst($product_type) }})</h2>
        <div class="product">
            <h3>{{ $product_title }}</h3>
            <p>{{ $product_description }}</p>
            <div>
                <strong>Generated Image:</strong><br>
                <a href="{{ $image_url }}" target="_blank"><img src="{{ $image_url }}" alt="Generated Image"></a>
            </div>
            <div>
                <strong>Product Mockup:</strong><br>
                <a href="{{ $mockup_url }}" target="_blank"><img src="{{ $mockup_url }}" alt="Mockup"></a>
            </div>
        </div>
    </div>
    @endisset
</body>
</html>
