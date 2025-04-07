import React, { useState } from 'react';
import { TextField, Button, Box, Autocomplete } from '@mui/material';

const FormulaireComplet = () => {
    const [name, setName] = useState('');
    const [firstName, setFirstName] = useState('');
    const [email, setEmail] = useState('');
    const [address, setAddress] = useState('');
    const [phone, setPhone] = useState('');
    const [question, setQuestion] = useState('');
    const [suggestions, setSuggestions] = useState([]);

    const [nameError, setNameError] = useState(false);
    const [nameValid, setNameValid] = useState(false);
    const [firstNameError, setFirstNameError] = useState(false);
    const [firstNameValid, setFirstNameValid] = useState(false);
    const [emailError, setEmailError] = useState(false);
    const [emailValid, setEmailValid] = useState(false);
    const [addressError, setAddressError] = useState(false);
    const [addressValid, setAddressValid] = useState(false);
    const [phoneError, setPhoneError] = useState(false);
    const [phoneValid, setPhoneValid] = useState(false);
    const [questionError, setQuestionError] = useState(false);
    const [questionValid, setQuestionValid] = useState(false);

    // API Adresse.gouv.fr pour les suggestions d'adresses
    const fetchSuggestions = async (query) => {
        if (query.length > 2) {
            try {
                const response = await fetch(`https://api-adresse.data.gouv.fr/search/?q=${query}`);
                const data = await response.json();
                setSuggestions(data.features.map((feature) => feature.properties.label));
            } catch (error) {
                console.error('Erreur lors de la récupération des suggestions :', error);
            }
        }
    };

    // Validation des champs
    const validateName = (value) => {
        const regex = /^[a-zA-ZÀ-ÖØ-öø-ÿ\s'-]+$/;
        setNameError(!regex.test(value));
        setNameValid(regex.test(value));
    };

    const validateFirstName = (value) => {
        const regex = /^[a-zA-ZÀ-ÖØ-öø-ÿ\s'-]+$/;
        setFirstNameError(!regex.test(value));
        setFirstNameValid(regex.test(value));
    };

    const validateEmail = (value) => {
        const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        setEmailError(!regex.test(value));
        setEmailValid(regex.test(value));
    };

    const validatePhone = (value) => {
        const regex = /^\d{10}$/; // Vérifie que le téléphone contient exactement 10 chiffres
        setPhoneError(!regex.test(value));
        setPhoneValid(regex.test(value));
    };

    const validateAddress = (value) => {
        setAddressError(value.trim() === '');
        setAddressValid(value.trim() !== '');
    };

    const validateQuestion = (value) => {
        setQuestionError(value.trim() === '');
        setQuestionValid(value.trim() !== '');
    };

    const handleSubmit = async (event) => {
        event.preventDefault(); // Empêche le rechargement de la page
    
        // Les données collectées à envoyer
        const formData = {
            name,
            firstName,
            email,
            address,
            phone,
            question,
        };
    
        try {
            // Requête POST à votre backend Symfony
            const response = await fetch('/contact', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(formData),
            });
    
            if (response.ok) {
                // En cas de succès
                console.log('Email envoyé avec succès');
                alert('Votre formulaire a été soumis avec succès !');
                setName('');
                setFirstName('');
                setEmail('');
                setAddress('');
                setPhone('');
                setQuestion('');
                setSuggestions([]);
            } else {
                // En cas d'erreur
                const errorData = await response.json();
                console.error('Erreur lors de l\'envoi :', errorData.message);
                alert('Une erreur est survenue lors de la soumission du formulaire.');
            }
        } catch (error) {
            console.error('Erreur réseau :', error);
            alert('Impossible de soumettre le formulaire, vérifiez votre connexion.');
        }
    };    

    return (
        <Box
            component="form"
            onSubmit={handleSubmit}
            sx={{
                maxWidth: 500,
                margin: '0 auto',
                padding: 2,
                boxShadow: 3,
                borderRadius: 2,
                border: `2px solid #980848`,
            }}
        >
            <TextField
                label="Nom"
                variant="outlined"
                fullWidth
                margin="normal"
                value={name}
                onChange={(e) => setName(e.target.value)}
                onBlur={() => validateName(name)}
                error={nameError}
                helperText={nameError ? 'Le nom ne doit contenir que des lettres.' : ''}
                required
                sx={{
                    '& .MuiOutlinedInput-root': {
                        borderColor: nameValid ? 'green' : undefined,
                        '& fieldset': {
                            borderColor: nameValid ? 'green' : undefined,
                        },
                    },
                    '& label': {
                        color: nameValid ? 'green' : undefined,
                    },
                }}
            />

            <TextField
                label="Prénom"
                variant="outlined"
                fullWidth
                margin="normal"
                value={firstName}
                onChange={(e) => setFirstName(e.target.value)}
                onBlur={() => validateFirstName(firstName)}
                error={firstNameError}
                helperText={firstNameError ? 'Le prénom ne doit contenir que des lettres.' : ''}
                required
                sx={{
                    '& .MuiOutlinedInput-root': {
                        borderColor: firstNameValid ? 'green' : undefined,
                        '& fieldset': {
                            borderColor: firstNameValid ? 'green' : undefined,
                        },
                    },
                    '& label': {
                        color: firstNameValid ? 'green' : undefined,
                    },
                }}
            />

            <TextField
                label="Email"
                variant="outlined"
                fullWidth
                margin="normal"
                value={email}
                onChange={(e) => setEmail(e.target.value)}
                onBlur={() => validateEmail(email)}
                error={emailError}
                helperText={emailError ? 'Adresse email invalide.' : ''}
                required
                sx={{
                    '& .MuiOutlinedInput-root': {
                        borderColor: emailValid ? 'green' : undefined,
                        '& fieldset': {
                            borderColor: emailValid ? 'green' : undefined,
                        },
                    },
                    '& label': {
                        color: emailValid ? 'green' : undefined,
                    },
                }}
            />

            <Autocomplete
                freeSolo
                options={suggestions}
                onInputChange={(event, value) => {
                    setAddress(value);
                    fetchSuggestions(value);
                }}
                renderInput={(params) => (
                    <TextField
                        {...params}
                        label="Adresse"
                        variant="outlined"
                        fullWidth
                        margin="normal"
                        value={address}
                        onChange={(e) => setAddress(e.target.value)}
                        onBlur={() => validateAddress(address)}
                        error={addressError}
                        helperText={addressError ? 'Veuillez saisir une adresse valide.' : ''}
                        required
                        sx={{
                            '& .MuiOutlinedInput-root': {
                                borderColor: addressValid ? 'green' : undefined,
                                '& fieldset': {
                                    borderColor: addressValid ? 'green' : undefined,
                                },
                            },
                            '& label': {
                                color: addressValid ? 'green' : undefined,
                            },
                        }}
                    />
                )}
            />

            <TextField
                label="Téléphone"
                variant="outlined"
                fullWidth
                margin="normal"
                value={phone}
                onChange={(e) => setPhone(e.target.value)}
                onBlur={() => validatePhone(phone)}
                error={phoneError}
                helperText={phoneError ? 'Le numéro de téléphone doit contenir exactement 10 chiffres.' : ''}
                required
                sx={{
                    '& .MuiOutlinedInput-root': {
                        borderColor: phoneValid ? 'green' : undefined,
                        '& fieldset': {
                            borderColor: phoneValid ? 'green' : undefined,
                        },
                    },
                    '& label': {
                        color: phoneValid ? 'green' : undefined,
                    },
                }}
            />

            <TextField
                label="Votre demande ou question"
                variant="outlined"
                fullWidth
                margin="normal"
                multiline
                rows={4}
                value={question}
                onChange={(e) => setQuestion(e.target.value)}
                onBlur={() => validateQuestion(question)}
                error={questionError}
                helperText={questionError ? 'Ce champ est requis.' : ''}
                required
                sx={{
                    '& .MuiOutlinedInput-root': {
                        borderColor: questionValid ? 'green' : undefined,
                        '& fieldset': {
                            borderColor: questionValid ? 'green' : undefined,
                        },
                    },
                    '& label': {
                        color: questionValid ? 'green' : undefined,
                    },
                }}
            />

            <Button
                type="submit"
                variant="contained"
                fullWidth
                sx={{
                    mt: 2,
                    backgroundColor: '#980848', // Couleur personnalisée pour le bouton
                    '&:hover': {
                        backgroundColor: '#78063c', // Couleur du bouton au survol
                    },
                }}
            >
                Soumettre
            </Button>
        </Box>
    );
};

export default FormulaireComplet;
