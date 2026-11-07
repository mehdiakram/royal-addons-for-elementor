var RoyalCardMakerHandler = function($scope, $) {
    const wrapper = $scope.find('.rt-card-maker-wrapper')[0];
    if (!wrapper) return;

    const settings = JSON.parse(wrapper.dataset.settings);
    const canvas = $scope.find('.rt-card-maker-canvas')[0];
    const ctx = canvas.getContext('2d');

    const imageUploader = $scope.find('.rt-image-uploader')[0];
    const input1 = $scope.find('.rt-card-maker-input-one')[0];
    const input2 = $scope.find('.rt-card-maker-input-two')[0];
    const downloadBtn = $scope.find('.rt-card-maker-download-btn')[0];

    let visitorImage = null;
    let maskImage = new Image();
    maskImage.crossOrigin = "anonymous";

    let isDragging = false;
    let imagePos = { x: 0, y: 0 };
    let dragStart = { x: 0, y: 0 };

    function drawAlignedLine(context, line, x, y, maxWidth, align) {
        let drawX;
        context.textAlign = align;
        if (align === 'right') { drawX = x + maxWidth; } 
        else if (align === 'center') { drawX = x + (maxWidth / 2); } 
        else { drawX = x; }
        context.fillText(line.trim(), drawX, y);
    }

    function wrapText(context, text, x, y, maxWidth, lineHeight, align) {
        const words = text.split(' ');
        let line = '';
        let currentY = y;
        for (let n = 0; n < words.length; n++) {
            const testLine = line + words[n] + ' ';
            const metrics = context.measureText(testLine);
            if (metrics.width > maxWidth && n > 0) {
                drawAlignedLine(context, line, x, currentY, maxWidth, align);
                line = words[n] + ' ';
                currentY += lineHeight;
            } else {
                line = testLine;
            }
        }
        drawAlignedLine(context, line, x, currentY, maxWidth, align);
    }

    const initCanvas = () => {
        canvas.width = settings.width;
        canvas.height = settings.height;
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        
        ctx.fillStyle = '#f0f0f0';
        ctx.fillRect(0, 0, canvas.width, canvas.height);
        ctx.fillStyle = '#888';
        ctx.textAlign = 'center';
        ctx.font = '20px Arial';
        ctx.fillText('Upload an image to start', canvas.width / 2, canvas.height / 2);

        if (settings.mask_url) {
            maskImage.src = settings.mask_url;
            maskImage.onload = redrawCanvas;
            maskImage.onerror = () => console.error("Failed to load mask image.");
        }
    };

    const redrawCanvas = () => {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        ctx.fillStyle = '#FFFFFF';
        ctx.fillRect(0, 0, canvas.width, canvas.height);
        if (visitorImage) {
            ctx.drawImage(visitorImage, imagePos.x, imagePos.y);
        }
        if (maskImage.complete && maskImage.naturalWidth !== 0) {
            ctx.drawImage(maskImage, 0, 0, canvas.width, canvas.height);
        }
        if (settings.input1.show && input1 && input1.value) {
            ctx.font = `${settings.input1.font_weight || 'normal'} ${settings.input1.font_size}px ${settings.input1.font_family || 'Arial'}`;
            ctx.fillStyle = settings.input1.color;
            const text1X = (canvas.width * settings.input1.x) / 100;
            const text1Y = (canvas.height * settings.input1.y) / 100;
            const maxWidth1 = settings.input1.box_width || 300;
            const lineHeight1 = (parseInt(settings.input1.font_size) || 30) * 1.2;
            wrapText(ctx, input1.value, text1X, text1Y, maxWidth1, lineHeight1, settings.input1.align);
        }
        if (settings.input2.show && input2 && input2.value) {
            ctx.font = `${settings.input2.font_weight || 'normal'} ${settings.input2.font_size}px ${settings.input2.font_family || 'Arial'}`;
            ctx.fillStyle = settings.input2.color;
            const text2X = (canvas.width * settings.input2.x) / 100;
            const text2Y = (canvas.height * settings.input2.y) / 100;
            const maxWidth2 = settings.input2.box_width || 300;
            const lineHeight2 = (parseInt(settings.input2.font_size) || 30) * 1.2;
            wrapText(ctx, input2.value, text2X, text2Y, maxWidth2, lineHeight2, settings.input2.align);
        }
    };

    function getMousePos(canvasEl, evt) {
        const rect = canvasEl.getBoundingClientRect();
        return { x: evt.clientX - rect.left, y: evt.clientY - rect.top };
    }

    canvas.addEventListener('mousedown', function(e) {
        if (visitorImage) { 
            isDragging = true;
            const mousePos = getMousePos(canvas, e);
            dragStart.x = mousePos.x - imagePos.x;
            dragStart.y = mousePos.y - imagePos.y;
        }
    });

    canvas.addEventListener('mouseup', function() { isDragging = false; });
    canvas.addEventListener('mouseout', function() { isDragging = false; });

    canvas.addEventListener('mousemove', function(e) {
        if (isDragging) {
            const mousePos = getMousePos(canvas, e);
            imagePos.x = mousePos.x - dragStart.x;
            imagePos.y = mousePos.y - dragStart.y;
            redrawCanvas();
        }
    });

    imageUploader.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(event) {
                visitorImage = new Image();
                visitorImage.onload = () => {
                    const initialX = ((canvas.width * settings.visitor_img_x) / 100) - (visitorImage.width / 2);
                    const initialY = ((canvas.height * settings.visitor_img_y) / 100) - (visitorImage.height / 2);
                    imagePos = { x: initialX, y: initialY };
                    redrawCanvas();
                };
                visitorImage.src = event.target.result;
            };
            reader.readAsDataURL(file);
        }
    });

    if (input1) input1.addEventListener('input', redrawCanvas);
    if (input2) input2.addEventListener('input', redrawCanvas);
    
    downloadBtn.addEventListener('click', function() {
        this.disabled = true; this.innerText = 'Downloading...';
        redrawCanvas();
        const dataURL = canvas.toDataURL('image/png');
        const link = document.createElement('a');
        link.download = 'royal-card.png';
        link.href = dataURL;
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
        this.disabled = false; this.innerText = 'Download Image';
    });

    initCanvas();
};

jQuery(window).on('elementor/frontend/init', function() {
    elementorFrontend.hooks.addAction('frontend/element_ready/royalcardmaker.default', RoyalCardMakerHandler);
});