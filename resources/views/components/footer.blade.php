<footer class="main-footer bg-whitesmoke">
    <div class="footer-right" style="margin-left:auto;">
        Copyright &copy; 2024 Digitalisasi KIP Merdeka LLDIKTI Wilayah II. All Right Reserved. | 1.0.0
    </div>
</footer>

<style>
/* Sticky footer layout */
html, body, #app {
    height: 100%;
    min-height: 100%;
}
.main-wrapper {
    min-height: 100vh;
    display: flex;
    flex-direction: column;
}
.main-footer {
    margin-top: auto;
    /* Optional styling */
    padding: 15px 20px;
    font-size: 14px;
    border-top: 1px solid #e4e6fc;
    background: #f9f9f9;
    color: #888;
    display: flex;
    justify-content: flex-end;
    align-items: center;
}

@media (max-width: 768px) {
    .main-footer {
        flex-direction: column;
        text-align: center;
        gap: 5px;
    }
}
</style>