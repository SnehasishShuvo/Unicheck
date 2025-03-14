// script.js

document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('eligibilityForm');
    const result = document.getElementById('result');
    
    // University requirements database
    const universities = {
        science: [
            {
                name: "Bangladesh University of Engineering and Technology (BUET)",
                minHscGpa: 4.5,
                minSscGpa: 4.0,
                requirements: [
                    "Minimum A- in Physics, Chemistry, and Math in HSC",
                    "Must pass admission test",
                    "HSC and SSC combined GPA must be above 8.5"
                ],
                ranking: 1,
                website: "https://www.buet.ac.bd/"
            },
            {
                name: "University of Dhaka (Science Faculty)",
                minHscGpa: 4.0,
                minSscGpa: 4.0,
                requirements: [
                    "Minimum A in two science subjects in HSC",
                    "Must pass admission test",
                    "Combined GPA must be above 8.0"
                ],
                ranking: 2,
                website: "https://www.du.ac.bd/"
            },
            {
                name: "Bangladesh Agricultural University",
                minHscGpa: 3.5,
                minSscGpa: 3.5,
                requirements: [
                    "Minimum B in Biology in HSC",
                    "Science background required",
                    "Combined GPA must be above 7.0"
                ],
                ranking: 3,
                website: "https://www.bau.edu.bd/"
            },
            {
                name: "Khulna University of Engineering & Technology (KUET)",
                minHscGpa: 4.0,
                minSscGpa: 4.0,
                requirements: [
                    "Minimum A in Math and Physics in HSC",
                    "Must pass admission test",
                    "Combined GPA must be above 8.0"
                ],
                ranking: 4,
                website: "https://www.kuet.ac.bd/"
            },
            {
                name: "Rajshahi University of Engineering & Technology (RUET)",
                minHscGpa: 4.0,
                minSscGpa: 4.0,
                requirements: [
                    "Minimum A- in science subjects in HSC",
                    "Must pass admission test",
                    "Combined GPA must be above 8.0"
                ],
                ranking: 5,
                website: "https://www.ruet.ac.bd/"
            }
        ],
        commerce: [
            {
                name: "Institute of Business Administration (IBA), University of Dhaka",
                minHscGpa: 4.0,
                minSscGpa: 4.0,
                requirements: [
                    "Minimum A in Mathematics in HSC",
                    "Must pass admission test",
                    "Combined GPA must be above 8.0"
                ],
                ranking: 1,
                website: "https://www.iba-du.edu/"
            },
            {
                name: "Faculty of Business Studies, University of Dhaka",
                minHscGpa: 3.5,
                minSscGpa: 3.5,
                requirements: [
                    "Commerce background required",
                    "Must pass admission test",
                    "Combined GPA must be above 7.0"
                ],
                ranking: 2,
                website: "https://www.du.ac.bd/academic/faculty_bus"
            },
            {
                name: "North South University (Business School)",
                minHscGpa: 3.0,
                minSscGpa: 3.0,
                requirements: [
                    "No admission test",
                    "Direct admission based on GPA",
                    "Combined GPA must be above 6.0"
                ],
                ranking: 3,
                website: "http://www.northsouth.edu/"
            },
            {
                name: "Independent University Bangladesh (School of Business)",
                minHscGpa: 3.0,
                minSscGpa: 3.0,
                requirements: [
                    "English proficiency test required",
                    "Interview required",
                    "Combined GPA must be above 6.0"
                ],
                ranking: 4,
                website: "http://www.iub.edu.bd/"
            },
            {
                name: "BRAC University (BRAC Business School)",
                minHscGpa: 3.0,
                minSscGpa: 3.0,
                requirements: [
                    "English proficiency test required",
                    "Interview may be required",
                    "Combined GPA must be above 6.0"
                ],
                ranking: 5,
                website: "https://www.bracu.ac.bd/"
            }
        ],
        arts: [
            {
                name: "University of Dhaka (Arts Faculty)",
                minHscGpa: 3.5,
                minSscGpa: 3.5,
                requirements: [
                    "Must pass admission test",
                    "Subject-specific requirements may apply",
                    "Combined GPA must be above 7.0"
                ],
                ranking: 1,
                website: "https://www.du.ac.bd/academic/faculty_arts"
            },
            {
                name: "Jahangirnagar University (Arts Faculty)",
                minHscGpa: 3.0,
                minSscGpa: 3.0,
                requirements: [
                    "Must pass admission test",
                    "Interview may be required",
                    "Combined GPA must be above 6.0"
                ],
                ranking: 2,
                website: "https://www.ju.ac.bd/"
            },
            {
                name: "University of Chittagong (Arts Faculty)",
                minHscGpa: 3.0,
                minSscGpa: 3.0,
                requirements: [
                    "Must pass admission test",
                    "Combined GPA must be above 6.0"
                ],
                ranking: 3,
                website: "https://cu.ac.bd/"
            },
            {
                name: "East West University (Liberal Arts)",
                minHscGpa: 2.5,
                minSscGpa: 2.5,
                requirements: [
                    "English proficiency test required",
                    "No admission test",
                    "Combined GPA must be above 5.0"
                ],
                ranking: 4,
                website: "https://www.ewubd.edu/"
            },
            {
                name: "American International University Bangladesh (Arts)",
                minHscGpa: 2.5,
                minSscGpa: 2.5,
                requirements: [
                    "English proficiency test required",
                    "Interview may be required",
                    "Combined GPA must be above 5.0"
                ],
                ranking: 5,
                website: "https://www.aiub.edu/"
            }
        ]
    };
    
    // Add input animations
    const inputs = document.querySelectorAll('.input-field');
    inputs.forEach(input => {
        input.addEventListener('focus', () => {
            input.closest('.input-group').style.transform = 'translateY(-2px)';
        });
        
        input.addEventListener('blur', () => {
            input.closest('.input-group').style.transform = 'translateY(0)';
        });
    });

    form.addEventListener('submit', (e) => {
        e.preventDefault();
        
        // Get form values
        const hscGpa = parseFloat(document.getElementById('hscGpa').value);
        const sscGpa = parseFloat(document.getElementById('sscGpa').value);
        const hscYear = parseInt(document.getElementById('hscYear').value);
        const sscYear = parseInt(document.getElementById('sscYear').value);
        const subject = document.getElementById('subject').value;
        
        // Hide previous result with animation
        result.style.display = 'none';
        result.classList.remove('animate__fadeIn');
        
        // Validate inputs
        if (hscGpa < 1 || hscGpa > 5 || sscGpa < 1 || sscGpa > 5) {
            showResult('<div class="error">Please enter valid GPAs between 1 and 5</div>', 'error');
            return;
        }
        
        const currentYear = new Date().getFullYear();
        if (hscYear < 2000 || hscYear > currentYear || sscYear < 2000 || sscYear > currentYear) {
            showResult('<div class="error">Please enter valid passing years</div>', 'error');
            return;
        }
        
        if (sscYear >= hscYear) {
            showResult('<div class="error">SSC passing year must be before HSC passing year</div>', 'error');
            return;
        }
        
        // Find eligible universities
        const eligibleUniversities = universities[subject]
            .filter(uni => hscGpa >= uni.minHscGpa && sscGpa >= uni.minSscGpa)
            .sort((a, b) => a.ranking - b.ranking);
        
        // Generate result HTML
        if (eligibleUniversities.length > 0) {
            const resultHTML = `
                <div class="success">
                    <h4 class="mb-3">🎉 Congratulations! You are eligible for the following universities:</h4>
                    <div class="university-list">
                        ${eligibleUniversities.map(uni => `
                            <div class="university-card mb-3 p-3 bg-white rounded shadow-sm">
                                <h5 class="text-primary mb-2">${uni.name}</h5>
                                <p class="mb-2"><strong>Minimum HSC GPA Required:</strong> ${uni.minHscGpa}</p>
                                <p class="mb-2"><strong>Minimum SSC GPA Required:</strong> ${uni.minSscGpa}</p>
                                <p class="mb-2"><strong>Requirements:</strong></p>
                                <ul class="mb-3">
                                    ${uni.requirements.map(req => `<li>${req}</li>`).join('')}
                                </ul>
                                <a href="${uni.website}" class="btn btn-sm btn-outline-primary" target="_blank">
                                    <i class="fas fa-external-link-alt me-1"></i>
                                    Visit Official Website
                                </a>
                            </div>
                        `).join('')}
                    </div>
                </div>`;
            showResult(resultHTML);
        } else {
            showResult(`
                <div class="error">
                    <h4 class="mb-3">😔 No Universities Found</h4>
                    <p>Unfortunately, your GPAs (HSC: ${hscGpa}, SSC: ${sscGpa}) do not meet the minimum requirements for ${subject} programs.</p>
                    <p>Minimum GPA requirements:</p>
                    <ul>
                        <li>Science: HSC 3.5, SSC 3.5</li>
                        <li>Commerce: HSC 3.0, SSC 3.0</li>
                        <li>Arts: HSC 2.5, SSC 2.5</li>
                    </ul>
                    <p>Consider exploring other options or improving your grades.</p>
                </div>
            `, 'error');
        }
    });
    
    function showResult(message, type = '') {
        result.innerHTML = message;
        result.className = `mt-4 animate__animated animate__fadeIn ${type}`;
        result.style.display = 'block';
        
        // Update university count if available
        const universityCount = document.getElementById('universityCount');
        if (universityCount) {
            const count = document.querySelectorAll('.university-card').length;
            universityCount.textContent = count;
        }
        
        // Scroll to result if not visible
        const resultRect = result.getBoundingClientRect();
        const isVisible = (resultRect.top >= 0) && (resultRect.bottom <= window.innerHeight);
        
        if (!isVisible) {
            result.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        }
    }
});
