
function getIndexValue(arr, value) {
    var result = arr.length + 1;
    for (var i = 0; i < arr.length; i++) {
        if (arr[i].Id == value) {
            result = i;
        }
    }
    return result;
}

//convert flat array to nested array
function nested(arr) {
    var tree = [],
        mappedArr = {},
        arrElem,
        mappedElem;

    // First map the nodes of the array to an object -> create a hash table.
    for (var i = 0, len = arr.length; i < len; i++) {
        arrElem = arr[i];
        mappedArr[arrElem.Id] = arrElem;
        mappedArr[arrElem.Id]['children'] = [];
    }


    for (var id in mappedArr) {
        if (mappedArr.hasOwnProperty(id)) {
            mappedElem = mappedArr[id];
            // If the element is not at the root level, add it to its parent array of children.
            if (mappedElem.ParentId) {
                mappedArr[mappedElem['ParentId']]['children'].push(mappedElem);
            }
                // If the element is at the root level, add it to first level elements array.
            else {
                tree.push(mappedElem);
            }
        }
    }
    return tree;
}