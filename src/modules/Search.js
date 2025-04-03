class Search {
  // 1. describe and create/initiate our object
  constructor() {
    this.openButtons = document.querySelectorAll(".js-search-trigger");
    this.closeButton = document.querySelector(".search-overlay__close");
    this.searchOverlay = document.querySelector(".search-overlay");
    this.searchField = document.querySelector("#search-term");
    this.resultsDiv = document.querySelector("#search-overlay__results");
    this.isSpinnerVisible = false;
    this.isOverlayOpen = false;
    this.previousValue;
    this.typingTimer;
    this.events();
  }

  // 2. events
  events() {
    this.openButtons.forEach((button) =>
      button.addEventListener("click", this.openOverlay.bind(this))
    );
    this.closeButton.addEventListener("click", this.closeOverlay.bind(this));

    document.body.addEventListener(
      "keydown",
      this.keyPressDispatcher.bind(this)
    );

    document.body.addEventListener("keyup", this.typingLogic.bind(this));
  }

  typingLogic() {
    if (this.searchField.value != this.previousValue) {
      clearTimeout(this.typingTimer);

      if (this.searchField.innerHTML === "") {
        if (!this.isSpinnerVisible) {
          this.resultsDiv.innerHTML = `<div class="spinner-loader"></div>`;
          this.isSpinnerVisible = true;
        }
        this.typingTimer = setTimeout(this.getResults.bind(this), 750);
      } else {
        this.resultsDiv.innerHTML = "";
        this.isSpinnerVisible = false;
      }

      this.previousValue = this.searchField.value;
    }
  }

  getResults() {
    this.resultsDiv.innerHTML = "<h2>Here is your results</h2>";
  }

  keyPressDispatcher(e) {
    {
      if (e.key == "Shift" && !this.isOverlayOpen) {
        this.openOverlay();
      }

      if (e.key == "Escape" && this.isOverlayOpen) {
        this.closeOverlay();
      }
    }
  }

  openOverlay() {
    this.searchOverlay.classList.add("search-overlay--active");
    document.body.classList.add("body-no-scroll");
    this.isOverlayOpen = true;
  }

  closeOverlay() {
    this.searchOverlay.classList.remove("search-overlay--active");
    document.body.classList.remove("body-no-scroll");
    this.isOverlayOpen = false;
  }
}

let search = new Search();
