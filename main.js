function showCategories  (id) {
    let categoryBlocks = document.querySelectorAll('.categories-tree')    
    for (let i = 0; i < categoryBlocks.length; i++) {
        categoryBlocks[i].style.display = 'none'
    }
    categoryBlocks[id].style.display = 'block';
}