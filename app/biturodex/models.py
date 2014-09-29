class TypeEvenement :
	'''(NULL)'''
	def __init__(self) :
		self.nom = None # 
		pass
	def listertypes (self) :
		# returns 
		pass
class Utilisateur :
	def __init__(self) :
		self.username = None # 
		self.nom = None # 
		self.prenom = None # 
		self.email = None # 
		self.passwd = None # 
		pass
	def cree_evenement (self) :
		# returns 
		pass
class Etablissement :
	'''(NULL)'''
	def __init__(self) :
		self.nom = None # 
		self.adresse0 = None # 
		self.adresse1 = None # 
		self.pays = None # 
		self.ville = None # 
		self.codepostal = None # 
		self.type = None # 
		self.horaires = None # 
		self.latitude = None # 
		self.longitude = None # 
		pass
	def obtenir_itineraire (self) :
		# returns itineraire
		pass
class Evenement :
	'''(NULL)'''
	def __init__(self) :
		self.type = None # 
		self.latitude = None # 
		self.rayon = None # 
		self.longitude = None # 
		self.horaires = None # 
		self.recurrences = None # 
		self.createur = None # Utilisateur
		self.etablissement = None # Etablissement
		pass
class Emploie :
	def __init__(self) :
		self.rôle = None # 
		self.horaires = None # 
		pass
class TypeEtablissement :
	'''(NULL)'''
	def __init__(self) :
		self.nom = None # 
		pass
	def listertypes (self) :
		# returns 
		pass
