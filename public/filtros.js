function applyColorblindFilter(filterName) {
    const contentWrapper = document.getElementById("main-content-wrapper");
    if (!contentWrapper) return; 

    const filterClasses = [
        "achromatomia", "achromatopsia", "deuteranomaly", "deuteranopia", 
        "protanomaly", "protanopia", "tritanomaly", "tritanopia"
    ];

    // Remove todas as classes de filtro existentes do container
    filterClasses.forEach(className => {
        contentWrapper.classList.remove(className);
    });

    // Aplica a nova classe se não for "default"
    if (filterName !== "default") {
        contentWrapper.classList.add(filterName);
    }

    localStorage.setItem("colorblind-filter", filterName);
}

window.onload = function () {

    const savedFilter = localStorage.getItem("colorblind-filter") || "default";
    
    applyColorblindFilter(savedFilter);
    const filterSelect = document.getElementById("colorblind-filter");
    if (filterSelect) {
        filterSelect.value = savedFilter;
    }
}