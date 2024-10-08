document.addEventListener('DOMContentLoaded', () => {
    const currentSkills = JSON.parse(document.getElementById('skills-container').getAttribute('data-employee-skills')) || [];
    document.getElementById('current_skills').value = JSON.stringify(currentSkills);
});

document.getElementById('view-skills').addEventListener('click', async function () {
    const response = await fetch('/api/vacancy/skills');

    if (!response.ok) {
        throw new Error('Failed to fetch skills');
    }

    const skillArray = await response.json();
    const container = document.getElementById('skills-container');
    const errorMessage = document.getElementById('error-message-skills');

    const employeeCurrentSkills = JSON.parse(document.getElementById('skills-container').getAttribute('data-employee-skills')) || [];
    const employeeCurrentSkillsNumbers = employeeCurrentSkills.map(Number);

    container.innerHTML = '';
    errorMessage.innerText = '';

    if (skillArray.length === 0) {
        errorMessage.innerText = 'Skills not found. Please contact support';
        return;
    }

    skillArray.forEach(skillSet => {
        const div = document.createElement('div');
        div.className = 'row justify-content-around gx-1';

        Object.keys(skillSet).forEach(category => {
            const skills = skillSet[category];
            const colDiv = document.createElement('div');
            colDiv.className = 'col col-lg-1';

            const categorySpan = document.createElement('span');
            categorySpan.className = 'fw-bold';
            categorySpan.textContent = category;
            colDiv.appendChild(categorySpan);

            const ul = document.createElement('ul');
            ul.className = 'list-unstyled overflow-auto mh-90';

            skills.forEach(skill => {
                const li = document.createElement('li');
                const label = document.createElement('label');
                label.className = 'category-label-column';
                label.htmlFor = skill.id;

                const input = document.createElement('input');
                input.type = 'checkbox';
                input.name = `skills[]`;
                input.value = skill.id;
                input.id = skill.id;

                if (employeeCurrentSkillsNumbers.includes(skill.id)) {
                    input.checked = true;
                }

                const span = document.createElement('span');
                span.textContent = skill.skillName;

                label.appendChild(input);
                label.appendChild(span);
                li.appendChild(label);
                ul.appendChild(li);
            });

            colDiv.appendChild(ul);
            div.appendChild(colDiv);
            container.appendChild(div);
        });
    });

    document.getElementById('hide-skills').classList.remove('d-none');
    container.classList.remove('d-none');
    this.classList.add('d-none');
});


document.getElementById('hide-skills').addEventListener('click', function () {
    this.classList.add('d-none');
    document.getElementById('skills-container').classList.add('d-none');
    document.getElementById('view-skills').classList.remove('d-none');
})

document.getElementById('employeeForm').addEventListener('submit', function (event) {
    event.preventDefault();

    const selectedSkills = Array.from(document.querySelectorAll('input[name="skills[]"]:checked'))
        .map(input => Number(input.value));

    const allSkills = [...new Set([...selectedSkills])];

    const form = event.target;
    form.querySelectorAll('input[name="skills[]"]').forEach(input => input.remove());

    allSkills.forEach(skillId => {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'skills[]';
        input.value = skillId;
        form.appendChild(input);
    });

    form.submit();
});

