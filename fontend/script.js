// Initialize Lucide icons
lucide.createIcons();

// Navigation
const $navLinks = $('.nav-link');
const $sections = $('.section');

function setActiveTab(tabId) {
    // Update navigation
    $navLinks.each(function() {
        $(this).toggleClass('active', $(this).data('tab') === tabId);
    });

    // Update sections
    $sections.each(function() {
        $(this).toggleClass('active', $(this).attr('id') === tabId);
    });
}

$navLinks.on('click', function() {
    setActiveTab($(this).data('tab'));
});

// Portfolio Modal
const $portfolioItems = $('.portfolio-item');
const $modal = $('#portfolio-modal');
const $modalBody = $modal.find('.modal-body');
const $closeModal = $modal.find('.close-modal');

const portfolioData = {
    1: {
        title: 'Tech Startup Branding test',
        process: [
            {
                stage: 'Research & Sketches',
                image: 'https://images.unsplash.com/photo-1517971071642-34a2d3ecc9cd?auto=format&fit=crop&q=80&w=500&h=300',
                description: 'Initial concept development and hand-drawn sketches.'
            },
            {
                stage: 'Digital Refinement',
                image: 'https://images.unsplash.com/photo-1611162617474-5b21e879e113?auto=format&fit=crop&q=80&w=500&h=300',
                description: 'Vector development and color exploration.'
            },
            {
                stage: 'Final Design',
                image: 'https://images.unsplash.com/photo-1626785774573-4b799315345d?auto=format&fit=crop&q=80&w=500&h=300',
                description: 'Polished final design with brand guidelines.'
            }
        ]
    }
};

function showModal(id) {
    const data = portfolioData[id];
    if (!data) {
        alert("Something went wrong");
        return;
    }

    let processHtml = '';
    data.process.forEach(function(stage) {
        processHtml += `
            <div>
                <h4 class="text-xl font-semibold mb-4">${stage.stage}</h4>
                <img src="${stage.image}" alt="${stage.stage}" class="w-full rounded-xl mb-4">
                <p class="text-gray-300">${stage.description}</p>
            </div>
        `;
    });

    $modalBody.html(`
        <h3 class="text-2xl font-bold mb-6">${data.title}</h3>
        <div class="space-y-8">${processHtml}</div>
    `);

    $modal.addClass('active');
}

$portfolioItems.on('click', function() {
    showModal($(this).data('id'));
});

$closeModal.on('click', function() {
    $modal.removeClass('active');
});

$modal.on('click', function(e) {
    if ($(e.target).is($modal)) {
        $modal.removeClass('active');
    }
});

// Contact Form
const $contactForm = $('#contact-form');

$contactForm.on('submit', function(e) {
    e.preventDefault();
    const formData = {
        name: $(this).find('[name="name"]').val(),
        email: $(this).find('[name="email"]').val(),
        message: $(this).find('[name="message"]').val()
    };
    console.log('Form submitted:', formData);
    // Add your form submission logic here
    $contactForm[0].reset();
});

$(document).ready(function() {
    // Set 'About' section active by default
    const $firstTab = $('.nav-link[data-tab="about"]');
    if ($firstTab.length) {
        $firstTab.addClass('active');
    }

    // Listen for tab clicks
    const $tabs = $('.nav-link');
    $tabs.on('click', function() {
        // Remove active class from all tabs
        $tabs.removeClass('active');

        // Add active class to the clicked tab
        $(this).addClass('active');

        // Hide all sections
        const $sections = $('.section');
        $sections.removeClass('active');

        // Show the corresponding section
        const tabName = $(this).data('tab');
        const $activeSection = $('#' + tabName);
        if ($activeSection.length) {
            $activeSection.addClass('active');
        }
    });
});
