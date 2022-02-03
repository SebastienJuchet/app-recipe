const addFormToCollection = (e) => {
    const collectionHolder = document.querySelector('.' + e.currentTarget.dataset.collectionHolderClass);

    const item = document.createElement('li');
    item.className = "list-group-item my-3";
    item.innerHTML = collectionHolder
        .dataset
        .prototype
        .replace(
            /__name__/g,
            collectionHolder.dataset.index
        );

    collectionHolder.appendChild(item);

    collectionHolder.dataset.index++;
};


document
    .querySelectorAll('.add_ingredient_link')
    .forEach(btn => {
        btn.addEventListener("click", addFormToCollection)
    })
;