function validateForm() {
  const questions = document.querySelectorAll('.question');
  if (questions.length < 1) {
    alert('Add at least one question!');
    return false;
  }

  for (let i = 0; i < questions.length; i++) {
    const qText = questions[i].querySelector('input[name="questions[]"]').value.trim();
    if (qText === '') {
      alert(`Question ${i + 1} cannot be empty.`);
      return false;
    }

    const opts = questions[i].querySelectorAll(`input[name="options${i}[]"]`);
    let filled = 0;
    opts.forEach(opt => {
      if (opt.value.trim() !== '') filled++;
    });

    if (filled < 4) {
      alert(`Each question must have 4 options.`);
      return false;
    }
  }

  return true;
}
