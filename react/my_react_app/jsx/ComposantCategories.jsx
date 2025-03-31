import React, { useEffect, useState } from 'react';
import axios from 'axios';

const ComposantCategories = () => {
    const [categories, setCategories] = useState([]);
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState(null);

    useEffect(() => {
        const fetchCategories = async () => {
            try {
                const response = await axios.get('https://127.0.0.1:8000/api/categories'); // Remplacez par votre API
                console.log('Données récupérées:', response.data); // Ajout pour débogage
                
                // Filtrer les catégories actives
                const activeCategories = response.data.filter(category => category.active === true);
                console.log('Catégories actives:', activeCategories);

                // Trier les catégories pour que celle avec l'ID 9 soit en dernier
                const sortedCategories = activeCategories.sort((a, b) => {
                    if (a.id === 9) return 1; // Place la catégorie avec l'ID 9 en dernier
                    if (b.id === 9) return -1; // Place les autres avant
                    return 0; // Pas de changement d'ordre
                });

                setCategories(sortedCategories);
            } catch (err) {
                console.error('Erreur lors de la récupération des catégories:', err); // Ajout pour débogage
                setError('Erreur lors de la récupération des catégories');
            } finally {
                setLoading(false);
            }
        };

        fetchCategories();
    }, []);

    if (loading) {
        return <div>Chargement des catégories...</div>;
    }

    if (error) {
        return <div>{error}</div>;
    }

    return (
        <div className="row">
            {categories.length === 0 ? (
                <div>Aucune catégorie disponible.</div>
            ) : (
                categories.map((category) => (
                    <div key={category.id} className="col-12 col-md-7 col-lg-4 p-lg-5 mb-5 mb-lg-0 d-flex justify-content-around">
                        <div className="card border-4 bordures rounded-5">
                            {/* IMAGE DE CATEGORIE */}
                            <img 
                                src={`/images/categories/${category.image}`} 
                                className="img-fluid m-3 rounded-4 border_image" 
                                alt={category.libelle} 
                                title={category.libelle} 
                            />

                            {/* BOUTON LIBELLE CATEGORIE */}
                            <a 
                                href={`/plats/par/cat?id=${category.id}`} // Remplacez par le bon chemin si nécessaire
                                className="card-text fs-5 fw-medium text-center shadow-lg p-2 m-3 mt-0 rounded-4 text-decoration-none fond_logo lettres_blanches"
                            >
                                {category.libelle.toUpperCase()}
                            </a>
                        </div>
                    </div>
                ))
            )}
        </div>
    );
};

export default ComposantCategories;