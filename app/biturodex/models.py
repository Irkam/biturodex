from django.db import models
from django.contrib.auth.models import User
from geoposition.fields import GeopositionField

class User(models.Model):
	user = models.OneToOneField(User)
	
	def get_workplaces(self):
		return Event.objects.all().filter(employees__in=[self.id])
	
class Country(models.Model):
	name = models.CharField(max_length=32)

class EventType(models.Model):
	name = models.CharField(max_length=32)

class EstablishmentType(models.Model):
	name = models.CharField(max_length=32)

class Establishment(models.Model):
	name = models.CharField(max_length=32)
	address0 = models.CharField(max_length=32, blank=True)
	address1 = models.CharField(max_length=32, blank=True)
	postcode = models.CharField(max_length=5, blank=True)
	city = models.CharField(max_length=32, blank=True)
	country = models.ForeignKey(Country, blank=True, null=True)
	type = models.ForeignKey(EventType)
	position = GeopositionField(blank=True, null=True)
	#TODO : horaires
	employees = models.ManyToManyField(User, blank=True, null=True)

class Event(models.Model):
	name = models.CharField(max_length=32)
	establishment = models.ForeignKey(Establishment, blank=True, null=True)
	address0 = models.CharField(max_length=32, blank=True)
	address1 = models.CharField(max_length=32, blank=True)
	postcode = models.CharField(max_length=5, blank=True)
	city = models.CharField(max_length=32, blank=True)
	country = models.ForeignKey(Country, blank=True, null=True)
	type = models.ForeignKey(EstablishmentType)
	position = GeopositionField(blank=True, null=True)
	#TODO: horaires
	employees = models.ManyToManyField(User, blank=True, null=True)