<!-- home.php -->

<!-- En-tête avec Tailwind CSS -->
<div class="p-6">
    <h1 class="text-3xl mb-4">Liste des Produits</h1>

    <?php
    // Arguments pour récupérer les produits
    $args = array(
        'post_type' => 'produit',
        'posts_per_page' => -1
    );

    // Nouvelle requête
    $loop = new WP_Query($args);

    // Vérifier s'il y a des produits
    if ($loop->have_posts()) :
    ?>
        <div class="overflow-hidden border-b border-gray-200 shadow sm:rounded-lg">
            <ul>
                <?php while ($loop->have_posts()) : $loop->the_post();
                    $image = get_field('field_image_produit');
                ?>
                    <li class="py-4 px-6 flex items-center justify-between">
                        <div class="flex items-center">
                            <?php if ($image) : ?>
                                <div class="flex-shrink-0 ">
                                    <img src="<?php echo esc_url($image['sizes']['large']); ?>" alt="<?php echo esc_attr($image['alt']); ?>" class=" h-auto w-12 object-contain">
                                </div>
                            <?php else : ?>
                                <div class="flex-shrink-0 h-12 w-12 bg-gray-200 rounded-full"></div>
                            <?php endif; ?>
                            <div class="ml-4">
                                <h2 class="text-lg font-medium text-gray-900"><?php the_title(); ?></h2>
                            </div>
                        </div>
                        <button class="ml-4 px-4 py-2 rounded bg-blue-500 text-white hover:bg-blue-600 focus:outline-none edit-image-button" data-post-id="<?php echo get_the_ID(); ?>">Modifier</button>
                    </li>
                <?php endwhile; ?>
            </ul>
        </div>
    <?php
    else :
        echo '<p class="mt-4">Aucun produit trouvé</p>';
    endif;

    // Réinitialiser les données post
    wp_reset_postdata();
    ?>
</div>

<!-- Modal améliorée avec Tailwind CSS -->
<div id="imageModal" class="fixed top-0 left-0 right-0 bottom-0 flex items-center justify-center bg-gray-800 bg-opacity-75 hidden">
    <div class="bg-white p-4 rounded-lg shadow-lg overflow-hidden max-w-3xl max-h-screen relative">
        <button id="closeModal" class="absolute top-2 right-2 text-gray-600 hover:text-gray-800 focus:outline-none">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
        <div class="flex">
    <div class="relative">
        <!-- Ajoutez une classe supplémentaire pour ajuster la largeur de l'image -->
        <img src="" alt="Image produit" id="modalImage" class="w-48 h-auto modal-image">
    </div>
    <div class="bg-white w-64 p-4 flex flex-col items-center justify-center">
        <button id="addZoneButton" class="p-2 rounded-full bg-gray-200 hover:bg-gray-300 mb-2 focus:outline-none">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-auto w-6 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
        </button>
        <!-- Nouveau bouton Enregistrer -->
        <button id="saveZonesButton" class="mt-2 px-4 py-2 rounded bg-blue-500 text-white hover:bg-blue-500 focus:outline-none">Enregistrer</button>
    </div>
</div>

    </div>
</div>


<!-- Script JavaScript pour gérer la modal, la zone de sécurité, et le redimensionnement -->
<script>
  jQuery(document).ready(function($) {
    let startX, startY, initialX, initialY, isResizing = false;
    const modal = $('#imageModal');
    const modalImage = $('#modalImage');
    let currentPostId = null;

    // Lorsque l'utilisateur clique sur le bouton d'édition d'image
    $('.edit-image-button').on('click', function(e) {
        e.preventDefault();

        const imageUrl = $(this).siblings('.flex').find('img').attr('src');
        currentPostId = $(this).data('post-id');

        $('#modalImage').attr('src', imageUrl);
        modal.removeClass('hidden').addClass('flex');

        // Charger les zones de sécurité existantes
        $.ajax({
            url: my_plugin_data.ajaxurl,
            method: 'GET',
            data: {
                action: 'get_product_zones',
                post_id: currentPostId,
                _ajax_nonce: my_plugin_data.nonce
            },
            success: function(response) {
                if (response.success) {
                    response.data.zones.forEach(zone => {
                        addZone(zone.x, zone.y, zone.width, zone.height);
                        
                    });
                } else {
                    console.error('Erreur lors du chargement des zones de sécurité.');
                }
            },
            error: function() {
                console.error('Erreur lors du chargement des zones de sécurité.');
            }
        });
    });

    // Fermer le modal
    $('#closeModal').on('click', function() {
        modal.removeClass('flex').addClass('hidden');
        modalImage.parent().find('.zone-securite').remove();
    });

    // Ajouter une nouvelle zone
    $('#addZoneButton').on('click', function() {
        addZone(10, 10, 100, 100); // Valeurs par défaut, à ajuster selon vos besoins
    });

    // Sauvegarder les zones de sécurité
    $('#saveZonesButton').on('click', function() {
        saveZones();
    });

    // Fonction pour ajouter une zone de sécurité
    function addZone(x, y, width, height) {
        const zone = $('<div class="absolute border-2 border-red-500 cursor-move resize zone-securite"><div class="resizer"></div></div>');
        modalImage.parent().append(zone);

        zone.css({
            width: `${width}%`,
            height: `${height}%`,
            top: `${y}%`,
            left: `${x}%`,
            position: 'absolute'
        });

        addDragAndResize(zone);
    }

    // Fonction pour sauvegarder les zones de sécurité via AJAX
    function saveZones() {
        const zones = [];

        modalImage.parent().find('.zone-securite').each(function() {
            const zone = $(this);
            const position = zone.position();
            const xPercent = (position.left / modalImage.width()) * 100;
            const yPercent = (position.top / modalImage.height()) * 100;
            const widthPercent = (zone.width() / modalImage.width()) * 100;
            const heightPercent = (zone.height() / modalImage.height()) * 100;

            zones.push({
                x: xPercent,
                y: yPercent,
                width: widthPercent,
                height: heightPercent
            });
        });

        $.ajax({
            url: my_plugin_data.ajaxurl,
            method: 'POST',
            data: {
                action: 'save_product_zones',
                post_id: currentPostId,
                zones: zones,
                _ajax_nonce: my_plugin_data.nonce
            },
            success: function(response) {
                if (response.success) {
                    console.log('Zones de sécurité enregistrées.');
                    modal.removeClass('flex').addClass('hidden');
                    modalImage.parent().find('.zone-securite').remove();
                } else {
                    console.error('Erreur lors de l\'enregistrement des zones de sécurité.');
                }
            },
            error: function() {
                console.error('Erreur lors de l\'enregistrement des zones de sécurité.');
            }
        });
    }

    // Fonction pour ajouter les événements de drag et resize à une zone
    function addDragAndResize(zone) {
        let isDragging = false;

        zone.on('mousedown', function(e) {
            if ($(e.target).hasClass('resizer')) {
                isResizing = true;
                startX = e.clientX;
                startY = e.clientY;
                initialX = zone.width();
                initialY = zone.height();
            } else {
                isDragging = true;
                startX = e.clientX - zone.position().left;
                startY = e.clientY - zone.position().top;
            }

            $(document).on('mousemove', function(e) {
                if (isDragging) {
                    const x = e.clientX - startX;
                    const y = e.clientY - startY;

                    const maxX = modalImage.width() - zone.width();
                    const maxY = modalImage.height() - zone.height();

                    zone.css({
                        left: `${Math.min(Math.max(0, x), maxX)}px`,
                        top: `${Math.min(Math.max(0, y), maxY)}px`
                    });
                }

                if (isResizing) {
                    const width = initialX + (e.clientX - startX);
                    const height = initialY + (e.clientY - startY);

                    zone.css({
                        width: `${width}px`,
                        height: `${height}px`
                    });
                }
            });

            $(document).on('mouseup', function() {
                isDragging = false;
                isResizing = false;
                $(document).off('mousemove');
                $(document).off('mouseup');
            });
        });

        zone.find('.resizer').on('mousedown', function(e) {
            e.stopPropagation();
            isResizing = true;
            startX = e.clientX;
            startY = e.clientY;
            initialX = zone.width();
            initialY = zone.height();

            $(document).on('mousemove', function(e) {
                if (isResizing) {
                    const width = initialX + (e.clientX - startX);
                    const height = initialY + (e.clientY - startY);

                    zone.css({
                        width: `${width}px`,
                        height: `${height}px`
                    });
                }
            });

            $(document).on('mouseup', function() {
                isResizing = false;
                $(document).off('mousemove');
                $(document).off('mouseup');
            });
        });
    }
});




</script>

<style>
    
    .resize {
        position: absolute;
        border: 2px solid gray;
    }

    .resizer {
        width: 10px;
        height: 10px;
        background: gray;
        position: absolute;
        right: 0;
        bottom: 0;
        cursor: se-resize;
    }
</style>
