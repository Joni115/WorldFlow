jQuery(document).ready(function($) {
    $('#summarize_button').click(function() {
        var inputText = $('#summarizer_input').val();

        // Disable the button and show the loader
        $('#summarize_button').attr('disabled', true);
        $('#loader').show();
        
        $.ajax({
            url: 'https://api.edenai.run/v2/text/summarize',
            method: 'POST',
            headers: {
                "Content-Type": "application/json",
                "Authorization": 'Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1c2VyX2lkIjoiMDNhYWU1NGItYWJmZC00YzRiLWE2N2QtOTA4YjY3YmJmNDc1IiwidHlwZSI6ImFwaV90b2tlbiJ9.5sF-KhZXt9_TI9lwho_VMNb8Gj4APtUsiD19MG9A6rI'
              },
            data: JSON.stringify({
                response_as_dict: true,
                attributes_as_list: false,
                show_base_64: true,
                show_original_response: false,
                output_sentences: 3,
                providers: 'openai',
                // providers: 'microsoft,emvista,openai,ai21labs,anthropic,alephalpha,nlpcloud,connexun,cohere',
                text: inputText,
                language: 'en'
            }),
            success: function(response) {
                $('#summarizer_output').val(response.openai.result);
            },
            error: function(xhr, status, error) {
                console.log(xhr.responseText);  // Log the error for more details
                alert('Error with summarizer API: ' + xhr.status + ' ' + xhr.statusText);
            },
            complete: function() {
                // Re-enable the button and hide the loader
                $('#summarize_button').attr('disabled', false);
                $('#loader').hide();
            }
        });
    });

    $('#paraphrase_button').click(function() {
        var inputText = $('#paraphraser_input').val();
    
        // Disable the button and show the loader
        $('#paraphrase_button').attr('disabled', true);
        $('#loader').show();
    
        $.ajax({
            url: 'https://api.ai21.com/studio/v1/paraphrase',  // Replace with actual paraphrasing API
            method: 'POST',
            headers: {
                "Authorization": "Bearer myMShBE8fFqewWSl07piXl3HDKYxRlHb",
                "Content-Type": "application/json"
            },
            data: JSON.stringify({
                text: inputText
            }),
            success: function(response) {
                if (response.suggestions && response.suggestions.length > 0) {
                    // Randomly select a paraphrased suggestion from the array
                    var randomIndex = Math.floor(Math.random() * response.suggestions.length);
                    $('#paraphraser_output').val(response.suggestions[randomIndex].text);
                } else {
                    alert('No paraphrased suggestions returned.');
                }
            },
            error: function(xhr, status, error) {
                console.log(xhr.responseText);  // Log the error for more details
                // alert('Error with paraphraser API: ' + xhr.status + ' ' + xhr.statusText);
                alert('Maximum 500 words allowed.');
            },
            complete: function() {
                // Re-enable the button and hide the loader
                $('#paraphrase_button').attr('disabled', false);
                $('#loader').hide();
            }
        });
    });
    
    
});
