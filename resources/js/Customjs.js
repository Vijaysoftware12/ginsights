
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
                                <p style="font-size: 35px;background-color:#ffff;"><i class="fa fa-refresh fa-spin"></i><span style="font-size: 35px; font-weight: bold; background-color:#ffff;">Loading...</span></p>   
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
        