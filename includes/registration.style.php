<?php
 echo '
 <style> 

html, body {
    margin: 0;
    height: 100%;
}


.left-panel {
    position: fixed;
    top: 0;
    left: 0;
    width: 50%;
    height: 100vh;
    background: linear-gradient(135deg, #0d0d0d, #333);
    color: white;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    text-align: center;
    padding: 2rem;
}

.left-panel img {
    max-width: 150px;
}

.right-panel {
    margin-left: 50%;
    width: 50%;
    min-height: 100vh;
    background: white;
    overflow-y: auto;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 2rem;
}

.form-wrapper {
    width: 100%;
    max-width: 600px;
}


.stepper {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
}

.step-item {
    text-align: center;
    width: 60px;
    flex-shrink: 0;
}

.step-number {
    width: 34px;
    height: 34px;
    border-radius: 50%;
    background: #dee2e6;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: auto;
    font-weight: bold;
}

.step-item.active .step-number {
    background: #0d6efd;
    color: white;
}

.step-line {
    flex-grow: 1;
    height: 2px;
    background: #dee2e6;
    margin: 0 5px;
}

.step-item.active + .step-line {
    background: #0d6efd;
}

.step-content {
    display: none;
}

.step-content.active {
    display: block;
}


@media (max-width: 991px) {

    html, body {
        height: auto;
        overflow-y: auto;
    }

    body {
        display: flex;
        flex-direction: column;
    }

    .left-panel,
    .right-panel {
        position: static;
        width: 100%;
        height: auto;
    }

    .right-panel {
        order: 1;
        margin-left: 0;
        padding: 1.5rem;
        align-items: flex-start;
        justify-content: flex-start;
    }

    .left-panel {
        order: 2;
        padding: 2rem 1.5rem;
        min-height: 280px;
    }

    .form-wrapper {
        max-width: 100%;
    }

    .step-item {
        width: 40px;
    }

    .step-number {
        width: 28px;
        height: 28px;
        font-size: 14px;
    }

    .step-label {
        font-size: 12px;
    }
}


@media (max-width: 576px) {

    .step-label {
        display: none;
    }

    .d-flex.justify-content-between {
        flex-direction: column;
        gap: 10px;
    }

    .btn {
        width: 100%;
    }
}


 </style>
 '
?>