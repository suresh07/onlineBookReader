// 
// This file shows the minimum you need to provide to BookReader to display a book
//
// Copyright(c)2008-2009 Internet Archive. Software license AGPL version 3.

// Create the BookReader object
br = new BookReader();

// Return the width of a given page.  Here we assume all images are 800 pixels wide
br.getPageWidth = function(index) {
    return 800;
}

// Return the height of a given page.  Here we assume all images are 1200 pixels high
br.getPageHeight = function(index) {
    return 1200;
}

//~ cachedList = window.localStorage.cachedElements.split(";");
//~ window.localStorage.cachedElements+=";"+"../img/"+level+"/" + book.imglist[index];
//~ if($.inArray("../img/"+level+"/"+book.imglist[index], cachedList) < 0)
// We load the images from archive.org -- you can modify this function to retrieve images
// using a different URL structure
br.getPageURI = function(index, reduce, rotate) {
	var level = Math.round(reduce) >= 2 ? 3 : (Math.round(reduce) >= 1 ? 2 : 1);
	console.log("No Image "+book.imglist[index]+" reduce "+level);
	$.ajax({type: "POST", url: "../templates/bgconvert.php?reduce="+reduce+"&index="+index, async: false, data : {book:this.book.imglist}});
	return "../img/"+level+"/" + book.imglist[index]
}

br.getBookId = function() {
	return book.bookId;
}
// Return which side, left or right, that a given page should be displayed on
br.getPageSide = function(index) {
    if (0 == (index & 0x1)) {
        return 'R';
    } else {
        return 'L';
    }
}

// This function returns the left and right indices for the user-visible
// spread that contains the given index.  The return values may be
// null if there is no facing page or the index is invalid.
br.getSpreadIndices = function(pindex) {   
    var spreadIndices = [null, null]; 
    if ('rl' == this.pageProgression) {
        // Right to Left
        if (this.getPageSide(pindex) == 'R') {
            spreadIndices[1] = pindex;
            spreadIndices[0] = pindex + 1;
        } else {
            // Given index was LHS
            spreadIndices[0] = pindex;
            spreadIndices[1] = pindex - 1;
        }
    } else {
        // Left to right
        if (this.getPageSide(pindex) == 'L') {
            spreadIndices[0] = pindex;
            spreadIndices[1] = pindex + 1;
        } else {
            // Given index was RHS
            spreadIndices[1] = pindex;
            spreadIndices[0] = pindex - 1;
        }
    }
    
    return spreadIndices;
}

// For a given "accessible page index" return the page number in the book.
//
// For example, index 5 might correspond to "Page 1" if there is front matter such
// as a title page and table of contents.
br.getPageNum = function(index) {
    return index+1;
}
// Total number of leafs
br.numLeafs = book.TotalPages;
// Book title and the URL used for the book title link
br.bookTitle= book.Title;

br.bookUrl  = book.SourceURL;

// Override the path used to find UI images
br.imagesBaseURL = '../static/BookReader/images/';

br.getEmbedCode = function(frameWidth, frameHeight, viewParams) {
    return "Embed code not supported in bookreader demo.";
}

// Let's go!
br.init();

// read-aloud and search need backend compenents and are not supported in the demo
//~ $('#BRtoolbar').find('.read').hide();
//~ $('#textSrch').hide();
//~ $('#btnSrch').hide();
