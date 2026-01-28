function data() {
  function getThemeFromLocalStorage() {
    // if user already changed the theme, use it
    if (window.localStorage.getItem('dark')) {
      return JSON.parse(window.localStorage.getItem('dark'))
    }

    // else return light mode by default
    return false
  }

  function setThemeToLocalStorage(value) {
    window.localStorage.setItem('dark', value)
  }

  return {
    dark: getThemeFromLocalStorage(),
    toggleTheme() {
      this.dark = !this.dark
      setThemeToLocalStorage(this.dark)
    },
    isNotificationsMenuOpen: false,
    toggleNotificationsMenu() {
      this.isNotificationsMenuOpen = !this.isNotificationsMenuOpen
    },
    closeNotificationsMenu() {
      this.isNotificationsMenuOpen = false
    },
    isProfileMenuOpen: false,
    toggleProfileMenu() {
      this.isProfileMenuOpen = !this.isProfileMenuOpen
    },
    closeProfileMenu() {
      this.isProfileMenuOpen = false
    },
    isProductsMenuOpen: false,
    toggleProductsMenu() {
      this.isProductsMenuOpen = !this.isProductsMenuOpen
    },
    isCategoriesMenuOpen: false,
    toggleCategoriesMenu() {
      this.isCategoriesMenuOpen = !this.isCategoriesMenuOpen
    },
    isUsersMenuOpen: false,
    toggleUsersMenu() {
      this.isUsersMenuOpen = !this.isUsersMenuOpen
    },
    // Tabs for single page admin
    currentTab: 'dashboard',
    switchTab(tab) {
      this.currentTab = tab
    },
    // Modal
    isModalOpen: false,
    trapCleanup: null,
    openModal() {
      this.isModalOpen = true
      this.trapCleanup = focusTrap(document.querySelector('#modal'))
    },
    closeModal() {
      this.isModalOpen = false
      this.trapCleanup()
    },
  }
}
