function nameOnly(selector) {
  const allowedRegex = /[^a-zA-ZñÑ.'\- ]/g;

  $(document).on("input", selector, function () {
    let val = this.value;

    val = val.replace(allowedRegex, "");
    val = val.replace(/^\s+/, "");
    val = val.replace(/\s{2,}/g, " ");
    val = val.replace(/-{2,}/g, "-");

    this.value = val;
  });

  $(document).on("blur", selector, function () {
    this.value = this.value.trim();
  });
}
