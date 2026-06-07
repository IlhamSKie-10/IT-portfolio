import fs from 'fs';

const html = fs.readFileSync('index.html', 'utf8');

const components = {
    'nav.blade.php': /<nav>[\s\S]*?<\/div>/, // Matches nav + mobile-nav since they are consecutive. Actually regex might be tricky.
    'hero.blade.php': /<section id="hero">[\s\S]*?<\/section>/,
    'about.blade.php': /<section id="about">[\s\S]*?<\/section>/,
    'tech-stack.blade.php': /<section id="tech-stack">[\s\S]*?<\/section>/,
    'projects.blade.php': /<section id="projects">[\s\S]*?<\/section>/,
    'experience.blade.php': /<section id="experience">[\s\S]*?<\/section>/,
    'contact.blade.php': /<section id="contact">[\s\S]*?<\/section>/,
    'footer.blade.php': /<footer>[\s\S]*?<\/footer>/
};

// Manually extract nav and mobile nav properly
const navStart = html.indexOf('<nav>');
const navEnd = html.indexOf('</div>', html.indexOf('<div class="mobile-nav"')) + 6;
fs.writeFileSync('resources/views/components/nav.blade.php', html.substring(navStart, navEnd));

for (const [file, regex] of Object.entries(components)) {
    if (file === 'nav.blade.php') continue;
    const match = html.match(regex);
    if (match) {
        let content = match[0];
        if (file === 'contact.blade.php') {
            // Replace static form with Livewire component
            content = content.replace(/<form[\s\S]*?<\/form>/, '<livewire:contact-form />');
        }
        fs.writeFileSync(`resources/views/components/${file}`, content);
    }
}

// Also extract CSS and append to app.css
const cssMatch = html.match(/<style>([\s\S]*?)<\/style>/);
if (cssMatch) {
    let css = cssMatch[1];
    // Remove the LARAVEL BLADE STRUCTURE REFERENCE comment block and the :root {} since we use @theme in app.css
    css = css.replace(/\/\*[\s\S]*?LARAVEL BLADE STRUCTURE REFERENCE[\s\S]*?\*\//, '');
    css = css.replace(/:root\s*\{[\s\S]*?\}/, '');
    css = css.replace(/body\s*\{[\s\S]*?\}/, ''); // Basic body is in app.css
    css = css.replace(/html\s*\{[\s\S]*?\}/, ''); // Basic html is in app.css
    fs.appendFileSync('resources/css/app.css', '\n\n/* ── Extracted from index.html ── */\n' + css);
}

// Create livewire view from the static form
const formMatch = html.match(/<form[\s\S]*?<\/form>/);
if (formMatch) {
    let formContent = formMatch[0];
    // Convert to Livewire form
    formContent = formContent.replace('<form class="contact-form">', '<form wire:submit="submit" class="contact-form">');
    formContent = formContent.replace('id="name" name="name"', 'id="name" wire:model="name"');
    formContent = formContent.replace('id="email" name="email"', 'id="email" wire:model="email"');
    formContent = formContent.replace('id="message" name="message"', 'id="message" wire:model="message"');
    
    // Add validation error display
    const errorTemplate = `
@error('$1') <span class="error-message text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
`;
    formContent = formContent.replace(/(<input[^>]+wire:model="name"[^>]*>)/, '$1' + errorTemplate.replace('$1', 'name'));
    formContent = formContent.replace(/(<input[^>]+wire:model="email"[^>]*>)/, '$1' + errorTemplate.replace('$1', 'email'));
    formContent = formContent.replace(/(<textarea[^>]+wire:model="message"[^>]*>)/, '$1' + errorTemplate.replace('$1', 'message'));
    
    fs.writeFileSync('resources/views/livewire/contact-form.blade.php', `<div>\n${formContent}\n</div>`);
}

console.log("Extraction complete.");
