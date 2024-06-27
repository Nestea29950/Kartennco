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
<div id="imageModal" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-75 hidden">
    <div class="bg-white p-6 rounded-lg shadow-lg overflow-hidden max-w-3xl max-h-screen relative">
        <button id="closeModal" class="absolute top-3 right-3 text-gray-500 hover:text-gray-700 focus:outline-none">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
        
        <div class="flex space-x-6">
            <div class="relative">
                <img src="" alt="Image produit" id="modalImage" class="w-64 h-auto rounded-lg shadow-md">
            </div>
            <div class="flex flex-col items-center justify-center space-y-4">
            <button id="addZoneButton" class="p-3 rounded-full bg-gray-200 hover:bg-gray-300 focus:outline-none shadow-sm">
    <img src="<?php echo esc_url(plugins_url('../assets/images/square.png', __FILE__)); ?>" width="24px" height="24px" alt="">
</button>


                <button id="addZoneButtonCircle" class="p-3 rounded-full bg-gray-200 hover:bg-gray-300 focus:outline-none shadow-sm">
                    <svg fill="#000000" width="24px" height="24px" viewBox="0 0 27 27" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd"
                        d="m13.5 26.5c1.412 0 2.794-.225 4.107-.662l-.316-.949c-1.212.403-2.487.611-3.792.611v1m6.06-1.495c1.234-.651 2.355-1.498 3.321-2.504l-.721-.692c-.892.929-1.928 1.711-3.067 2.312l.467.884m4.66-4.147c.79-1.149 1.391-2.418 1.777-3.762l-.961-.276c-.356 1.24-.911 2.411-1.64 3.471l.824.567m2.184-5.761c.063-.518.096-1.041.097-1.568 0-.896-.085-1.758-.255-2.603l-.98.197c.157.78.236 1.576.236 2.405-.001.486-.031.97-.09 1.448l.993.122m-.738-6.189c-.493-1.307-1.195-2.523-2.075-3.605l-.776.631c.812.999 1.46 2.122 1.916 3.327l.935-.353m-3.539-5.133c-1.043-.926-2.229-1.68-3.512-2.229l-.394.919c1.184.507 2.279 1.203 3.242 2.058l.664-.748m-5.463-2.886c-1.012-.253-2.058-.384-3.119-.388-.378 0-.717.013-1.059.039l.077.997c.316-.024.629-.036.98-.036.979.003 1.944.124 2.879.358l.243-.97m-6.238-.022c-1.361.33-2.653.878-3.832 1.619l.532.847c1.089-.684 2.281-1.189 3.536-1.494l-.236-.972m-5.517 2.878c-1.047.922-1.94 2.01-2.643 3.212l.864.504c.649-1.112 1.474-2.114 2.441-2.966l-.661-.75m-3.54 5.076c-.499 1.293-.789 2.664-.854 4.072l.999.046c.06-1.3.328-2.564.788-3.758l-.933-.36m-.78 6.202c.163 1.396.549 2.744 1.14 4l.905-.425c-.545-1.16-.902-2.404-1.052-3.692l-.993.116m2.177 5.814c.788 1.151 1.756 2.169 2.866 3.01l.606-.796c-1.025-.78-1.919-1.721-2.646-2.783l-.825.565m4.665 4.164c1.23.65 2.559 1.1 3.943 1.328l.162-.987c-1.278-.21-2.503-.625-3.638-1.225l-.468.884m6.02 1.501c.024 0 .024 0 .048 0v-1c-.022 0-.022 0-.044 0l-.004 1"/>
                    </svg>
                </button>

                <button id="saveZonesButton" class="px-5 py-3 rounded bg-blue-500 text-white hover:bg-blue-600 focus:outline-none shadow-md">Enregistrer</button>
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
        modalImage.parent().find('.zone-securite').remove(); // Supprimer les zones existantes
        addZone(10, 10, 100, 100 , false); // Ajouter une nouvelle zone
    });

    $('#addZoneButtonCircle').on('click', function() {
        modalImage.parent().find('.zone-securite').remove(); // Supprimer les zones existantes
        addZone(10, 10, 100, 100 , true); // Ajouter une nouvelle zone
    });

    // Sauvegarder les zones de sécurité
    $('#saveZonesButton').on('click', function() {
        saveZones();
    });

    // Fonction pour ajouter une zone de sécurité
    function addZone(x, y, width, height , circle) {
        const zone = $('<div class="absolute border-2 border-red-500 cursor-move resize zone-securite"><div class="resizer"></div></div>');
        modalImage.parent().append(zone);
        if(circle === true){
            zone.css({
            width: `${width}%`,
            height: `${height}%`,
            top: `${y}%`,
            left: `${x}%`,
            position: 'absolute',
            'border-radius': '99999px'
        });
        }
        else{
            zone.css({
            width: `${width}%`,
            height: `${height}%`,
            top: `${y}%`,
            left: `${x}%`,
            position: 'absolute',
            
        });
        }
            
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
                height: heightPercent,
                
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
        border: 2px dotted gray;
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
