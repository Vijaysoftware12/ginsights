
        document.addEventListener('DOMContentLoaded', function() {
            var divs = document.querySelectorAll('.text-blue.flex-1.mb-4.md\\:mb-0.rtl\\:md\\:ml-6.ltr\\:md\\:mr-6');
            
            divs.forEach(function(div) {
                var h3 = div.querySelector('h3');
                if (h3 && h3.textContent.trim() === 'GInsights Analytics') {
                 
                    // Add click event listener to the div
                    div.addEventListener('click', function() {
                        //alert('GInsights Analytics section clicked!');
                        var loadingElement = document.createElement('div');
                        loadingElement.id = 'loadingAnimation';
                        loadingElement.style.position = 'fixed';
                        loadingElement.style.top = '0';
                        loadingElement.style.left = '0';
                        loadingElement.style.width = '100%';
                        loadingElement.style.height = '100%';
                        loadingElement.style.backgroundColor = 'rgba(0, 0, 0, 0.5)'; // Semi-transparent background
                        loadingElement.style.display = 'flex';
                        loadingElement.style.justifyContent = 'center';
                        loadingElement.style.alignItems = 'center';
                        loadingElement.style.zIndex = '9999';
                        // Remove color and font size properties as they're not needed for a modal
                        loadingElement.style.color = '#000000';
                        loadingElement.style.fontSize = '40px';
    
                        // Replace innerHTML with modal HTML
                        loadingElement.innerHTML = `
                            <div class="modal">
                                <div class="modal-content">
                               <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid" width="200" height="200" style="shape-rendering: auto; display: block; background: transparent;" xmlns:xlink="http://www.w3.org/1999/xlink"><g><g transform="translate(80,50)">
<g transform="rotate(0)">
<circle fill-opacity="1" fill="#1065a6" r="6" cy="0" cx="0">
  <animateTransform repeatCount="indefinite" dur="1s" keyTimes="0;1" values="1.5 1.5;1 1" begin="-0.875s" type="scale" attributeName="transform"></animateTransform>
  <animate begin="-0.875s" values="1;0" repeatCount="indefinite" dur="1s" keyTimes="0;1" attributeName="fill-opacity"></animate>
</circle>
</g>
</g><g transform="translate(71.21320343559643,71.21320343559643)">
<g transform="rotate(45)">
<circle fill-opacity="0.875" fill="#1065a6" r="6" cy="0" cx="0">
  <animateTransform repeatCount="indefinite" dur="1s" keyTimes="0;1" values="1.5 1.5;1 1" begin="-0.75s" type="scale" attributeName="transform"></animateTransform>
  <animate begin="-0.75s" values="1;0" repeatCount="indefinite" dur="1s" keyTimes="0;1" attributeName="fill-opacity"></animate>
</circle>
</g>
</g><g transform="translate(50,80)">
<g transform="rotate(90)">
<circle fill-opacity="0.75" fill="#1065a6" r="6" cy="0" cx="0">
  <animateTransform repeatCount="indefinite" dur="1s" keyTimes="0;1" values="1.5 1.5;1 1" begin="-0.625s" type="scale" attributeName="transform"></animateTransform>
  <animate begin="-0.625s" values="1;0" repeatCount="indefinite" dur="1s" keyTimes="0;1" attributeName="fill-opacity"></animate>
</circle>
</g>
</g><g transform="translate(28.786796564403577,71.21320343559643)">
<g transform="rotate(135)">
<circle fill-opacity="0.625" fill="#1065a6" r="6" cy="0" cx="0">
  <animateTransform repeatCount="indefinite" dur="1s" keyTimes="0;1" values="1.5 1.5;1 1" begin="-0.5s" type="scale" attributeName="transform"></animateTransform>
  <animate begin="-0.5s" values="1;0" repeatCount="indefinite" dur="1s" keyTimes="0;1" attributeName="fill-opacity"></animate>
</circle>
</g>
</g><g transform="translate(20,50.00000000000001)">
<g transform="rotate(180)">
<circle fill-opacity="0.5" fill="#1065a6" r="6" cy="0" cx="0">
  <animateTransform repeatCount="indefinite" dur="1s" keyTimes="0;1" values="1.5 1.5;1 1" begin="-0.375s" type="scale" attributeName="transform"></animateTransform>
  <animate begin="-0.375s" values="1;0" repeatCount="indefinite" dur="1s" keyTimes="0;1" attributeName="fill-opacity"></animate>
</circle>
</g>
</g><g transform="translate(28.78679656440357,28.786796564403577)">
<g transform="rotate(225)">
<circle fill-opacity="0.375" fill="#1065a6" r="6" cy="0" cx="0">
  <animateTransform repeatCount="indefinite" dur="1s" keyTimes="0;1" values="1.5 1.5;1 1" begin="-0.25s" type="scale" attributeName="transform"></animateTransform>
  <animate begin="-0.25s" values="1;0" repeatCount="indefinite" dur="1s" keyTimes="0;1" attributeName="fill-opacity"></animate>
</circle>
</g>
</g><g transform="translate(49.99999999999999,20)">
<g transform="rotate(270)">
<circle fill-opacity="0.25" fill="#1065a6" r="6" cy="0" cx="0">
  <animateTransform repeatCount="indefinite" dur="1s" keyTimes="0;1" values="1.5 1.5;1 1" begin="-0.125s" type="scale" attributeName="transform"></animateTransform>
  <animate begin="-0.125s" values="1;0" repeatCount="indefinite" dur="1s" keyTimes="0;1" attributeName="fill-opacity"></animate>
</circle>
</g>
</g><g transform="translate(71.21320343559643,28.78679656440357)">
<g transform="rotate(315)">
<circle fill-opacity="0.125" fill="#1065a6" r="6" cy="0" cx="0">
  <animateTransform repeatCount="indefinite" dur="1s" keyTimes="0;1" values="1.5 1.5;1 1" begin="0s" type="scale" attributeName="transform"></animateTransform>
  <animate begin="0s" values="1;0" repeatCount="indefinite" dur="1s" keyTimes="0;1" attributeName="fill-opacity"></animate>
</circle>
</g>
</g><g></g></g><!-- [ldio] generated by https://loading.io --></svg>
                                <div class="loading-wheel"></div>
                                
                                </div>
                            </div>
                        `;
    
	
                        // Append modal to body
                        document.body.appendChild(loadingElement);
                    });
                }
            });
        });
        